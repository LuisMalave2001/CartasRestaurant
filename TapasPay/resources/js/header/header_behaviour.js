$(document).ready(function(){
    $('#current_establishment_id').on("change", function(){
        $('#loader').show();
        $.ajax({
            url: '/establishment/' + this.value,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'PUT',
            success: function(data){
                location.reload();
            },
            error: () => {
                $('#loader').hide();
            }
        });
    })
});
