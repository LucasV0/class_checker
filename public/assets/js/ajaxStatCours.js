function showStat(id){
    $(document).ready(function () {
            $.ajax({
                url: '/lesson/get/'+id,
                method: 'GET',
                success: function (data) {
                    let json = $.parseJSON(data);
                    console.log(json)

                }
            });
    });
}