<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3>Dashboard</h3>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">Welcome <b>{{ user.name }}</b></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="d-flex justify-content-between">
                <p class="m-2">Grafik Pemesanan Kendaraan Tahun 2024</p>
                <button type="button" class="btn btn-success m-2" @click="exportExcelApproved">export</button>
            </div>

            <Bar v-if="loaded" :data="chartData" />
        </div>
        <div class="card p-2 mt-2" id="AreaCetakapproved" v-show="hidetable">
            <div class="d-flex justify-content-between">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Pesanan Kendaraan </h5>
                <button type="button" class="btn btn-success" @click="exportExcelApproved">export</button>
            </div>

            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Kendaraan</th>
                        <th scope="col">Pengemudi</th>
                        <th scope="col">Tanggal Pemesanan</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(order, index) in orderapproved" :key="order.id">
                        <th scope="row">{{ index + 1 }}</th>
                        <td>{{ order.namakendaraan }}</td>
                        <td>{{ order.namapengemudi }}</td>
                        <td>{{ order.tanggal }}</td>
                        <td>{{ order.cek }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, BarElement, CategoryScale, LinearScale } from 'chart.js'
import Aa from '../../utils/file'

ChartJS.register(Title, Tooltip, BarElement, CategoryScale, LinearScale)
export default {
    name: "dashboard",
    components: { Bar },
    data() {
        return {
            user: this.$store.state.auth.user,
            loaded: false,
            chartData: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                datasets: [{ data: [] }]
            },
            hidetable:false,
            orderapproved:[]
        }
    },
    methods: {
        getCountOrderByMonth() {
            axios.get('/api/order/getByMonth')
                .then((res) => {
                    console.log(res)
                    const newData = res.data;
                    this.chartData.datasets[0].data = []; // Kosongkan array data sebelum menambahkan data baru
                    newData.forEach(item => {
                        this.chartData.datasets[0].data.push(item); // Tambahkan setiap angka baru dari respons Axios ke dalam array data
                    });
                    this.loaded = true
                })

        },
        async getorderlistapproved() {
            await axios.get('/api/order/getorderapproved')
                .then((res) => {
                    console.log(res)
                    this.orderapproved = res.data
                })
        },
        exportExcelApproved() {
            Aa.tableToExcel('AreaCetakapproved', 'Download aja', 'Approved order' + '.xls')
        },
    },
    mounted() {
        this.loaded = false
        this.getCountOrderByMonth();
        this.getorderlistapproved();

    },
}
</script>
