$(document).ready(function () {
    $('#kota').remoteChained({
        parents: '#provinsi',
        url: url,
        loading : loading
    })

    $('#kecamatan').remoteChained({
        parents: '#provinsi, #kota',
        url: url,
        loading : loading
    })

    $('#desa').remoteChained({
        parents: '#provinsi, #kota, #kecamatan',
        url: url,
        loading : loading
    })
})
