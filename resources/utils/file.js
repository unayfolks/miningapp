class ExportFile {

    tableToExcel = (table = '', name = '', filename = 'document.xls') => {
        const uri = 'data:application/vnd.ms-excel;base64,'
        const template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><title></title><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'

        const base64 = function (s) {
            return window.btoa(decodeURIComponent(encodeURIComponent(s)))
        }
        const format = function (s, c) {
            return s.replace(/{(\w+)}/g, function (m, p) {
                console.log(m);
                // m= m +' ';
                return c[p];
            })
        }

        if (!table.nodeType) table = document.getElementById(table)
        const ctx = {
            worksheet: name || 'Worksheet',
            table: table.innerHTML
        }

        const link = document.createElement('a')
        link.download = filename;
        link.href = uri + base64(format(template, ctx))
        link.click();
    }

}

export default new ExportFile();
