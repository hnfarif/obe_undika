"use strict";

$("#swal-1").click(function () {
    swal('Hello');
});

$("#swal-2").click(function () {
    swal('Good Job', 'You clicked the button!', 'success');
});

$("#swal-3").click(function () {
    swal('Good Job', 'You clicked the button!', 'warning');
});

$("#swal-4").click(function () {
    swal('Good Job', 'You clicked the button!', 'info');
});

$("#swal-5").click(function () {
    swal('Good Job', 'You clicked the button!', 'error');
});

var role = [{
        id: 1,
        name: 'Dosen'
    },
    {
        id: 2,
        name: 'P3AI'
    },
];

$("#swal-6").click(function () {
    swal({
            title: 'Are you sure?',
            text: 'Once deleted, you will not be able to recover this imaginary file!',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                swal('Poof! Your imaginary file has been deleted!', {
                    icon: 'success',
                });
            } else {
                swal('Your imaginary file is safe!');
            }
        });
});

$("#swal-7").click(function () {
    swal({
        title: 'Pilih Role',
        content: {
            element: 'select',
            options: role,
            attributes: {
                name: 'role',
                id: 'role'
            }
        },

        buttons: {
            cancel: true,
            confirm: true,
        },
    }).then((data) => {
        swal('Ganti Ke Role, ' + data + '!');
    });
});

$("#swal-8").click(function () {
    swal('This modal will disappear soon!', {
        buttons: false,
        timer: 3000,
    });
});
