<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Order Kendaraan</h3>
                        <button type="button" class="btn btn-primary" v-if="btnaddorder" @click="showadd">Add
                            Order</button>
                        <button type="button" class="btn btn-primary" v-if="!btnaddorder"
                            @click="hideadd">Close</button>
                    </div>
                </div>
                <div class="card p-2 mt-2" v-show="showaddorder">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pesanan Kendaraan</h5>
                    <div class="modal-body">
                        <!-- Form untuk input -->
                        <div class="form-group">
                            <label for="vehicleSelect">Pilih Kendaraan:</label>
                            <select class="form-control" id="vehicleSelect" v-model="newOrder.namakendaraan">
                                <option v-for="kendaraan in kendaraan" :value="kendaraan.nama" :key="kendaraan.id">{{
                            kendaraan.nama }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="driverSelect">Pilih Kendaraan:</label>
                            <select class="form-control" id="driverSelect" v-model="newOrder.namapengemudi">
                                <option v-for="pengemudi in pengemudi" :value="pengemudi.nama" :key="pengemudi.id">{{
                            pengemudi.nama }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal Pemesanan:</label>
                            <input type="date" class="form-control" id="tanggal" v-model="newOrder.tanggal">
                        </div>
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-primary" @click="addOrder">Tambah</button>
                    </div>
                </div>
                <div class="card p-2 mt-2" id="AreaCetakprocces">
                    <div class="d-flex justify-content-between">
                        <h5 class="modal-title" id="exampleModalLabel">Daftar Pesanan Kendaraan (Proses) </h5>
                        <button type="button" class="btn btn-success" @click="exportExcelProcces">export</button>
                    </div>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Kendaraan</th>
                                <th scope="col">Pengemudi</th>
                                <th scope="col">Tanggal Pemesanan</th>
                                <th scope="col">Status</th>
                                <th v-if="status" scope="col">Cek</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(order, index) in orderprocces" :key="order.id">
                                <th scope="row">{{ index + 1 }}</th>
                                <td>{{ order.namakendaraan }}</td>
                                <td>{{ order.namapengemudi }}</td>
                                <td>{{ order.tanggal }}</td>
                                <td>
                                    Waiting
                                </td>
                                <td v-if="status">
                                    <select class="custom-select" v-model="cekstatus" @change="changeStatus(order.id)">
                                        <option value="">Pilih tindakan</option>
                                        <option value="Approved">Aprove</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card p-2 mt-2" id="AreaCetakapproved">
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
                                <th v-if="status" scope="col">Cek</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(order, index) in orderapproved" :key="order.id">
                                <th scope="row">{{ index + 1 }}</th>
                                <td>{{ order.namakendaraan }}</td>
                                <td>{{ order.namapengemudi }}</td>
                                <td>{{ order.tanggal }}</td>
                                <td>{{ order.cek }}</td>
                                <td v-if="status">
                                    <select class="custom-select" v-model="cekstatus" @change="changeStatusWaiting(order.id)">
                                        <option value="">Pilih tindakan</option>
                                        <option value="Approved">Waiting</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
// resources\utils\file.js
import Aa from '../../utils/file'
export default {
    name: "order",
    data() {
        return {
            user: this.$store.state.auth.user,
            modalOpen: false,
            newOrder: {
                namakendaraan: '',
                namapengemudi: '',
                tanggal: ''
            },
            kendaraan: [],
            pengemudi: [],
            orderprocces: [],
            orderapproved: [],
            cekstatus: "",
            status: true,
            showaddorder: false,
            btnaddorder: true
        }
    },
    watch: {
        user() {
            console.log(this.$store.state.auth.user)
        }
    },
    methods: {
        hideadd() {
            this.showaddorder = false
            this.btnaddorder = true
        },
        showadd() {
            this.showaddorder = true
            this.btnaddorder = false
        },
        cektipeuser() {
            console.log(this.$store.state.auth.user.tipe)
            let tipe = this.$store.state.auth.user.tipe
            if (tipe == "Super Admin") {
                this.status = true
            } else {
                this.status = false
            }
        },
        async changeStatus(index) {
            console.log(this.cekstatus)
            console.log(index)
            await axios.put(`/api/order/changestatus/${index}`)
                .then((res) => {
                    console.log(res)
                    this.getorderlistinprocces();
                    this.getorderlistapproved();
                    this.cekstatus = ""
                    // this.kendaraan = res.data
                })
        },
        async changeStatusWaiting(index) {
            console.log(this.cekstatus)
            console.log(index)
            await axios.put(`/api/order/changestatuswaiting/${index}`)
                .then((res) => {
                    console.log(res)
                    this.getorderlistinprocces();
                    this.getorderlistapproved();
                    this.cekstatus = ""
                    // this.kendaraan = res.data
                })
        },
        async getkendaraan() {
            await axios.get('/api/kendaraan/getkendaraan')
                .then((res) => {
                    console.log(res)
                    this.kendaraan = res.data
                })
            await axios.get('/api/pengemudi/getpengemudi')
                .then((res) => {
                    this.pengemudi = res.data
                })
        },
        async getorderlistinprocces() {
            await axios.get('/api/order/getorderprocces')
                .then((res) => {
                    console.log(res)
                    this.orderprocces = res.data
                })
        },
        async getorderlistapproved() {
            await axios.get('/api/order/getorderapproved')
                .then((res) => {
                    console.log(res)
                    this.orderapproved = res.data
                })
        },
        addOrder() {
            axios.post('/api/orderkendaraan/addorder', this.newOrder)
                .then((response) => {
                    // console.log(response.data)
                    this.getorderlistinprocces();
                })
            // .catch(
            //     alert('Ada yang salah, cek kembali form nya')
            // )
        },
        exportExcelProcces() {
            alert('asdas')
            Aa.tableToExcel('AreaCetakprocces', 'Download aja', 'Waiting list order' + '.xls')
        },
        exportExcelApproved() {
            Aa.tableToExcel('AreaCetakapproved', 'Download aja', 'Approved order' + '.xls')
        },
    },
    mounted() {
        this.getorderlistapproved();
        this.getorderlistinprocces();
        this.getkendaraan();
        this.cektipeuser();
    },
}
</script>
