function actionDelete(event) {
    event.preventDefault();

    let urlRequest = $(this).attr('href');
    let that = $(this);
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'GET',
                url: urlRequest,
                success: function(data) {
                    if (data.code == 200) {
                        console.log(1);
                        that.parent().parent().remove();
                    }
                    else{
                        console.log(2);
                    }

                },
                error: function() {

                }
            })
            Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            )
        }
    })
}
$(function() {
    $(Document).on('click', '.action_delete', actionDelete);
});
