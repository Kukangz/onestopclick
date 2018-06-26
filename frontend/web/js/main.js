/*dashboard*/
$(document).ready(function() {
	demo.initDashboardPageCharts();
    demo.initVectorMap();

    $('#fb').click(function(){
        $(this).fbSignIn({ scope: 'email', auth_url: '', callback: function (resp) { 
            alert('try') }}); 
    });
    $('#gplus').click(function(e){

        e.preventDefault();
        

 });
});

/*login-page*/
$(document).ready(function() {
	setTimeout(function() {
     $('.card').removeClass('card-hidden');
 }, 700);
	demo.checkFullPageBackgroundImage();
});

/*form validasi*/
function setFormValidation(id) {
    $(id).validate({
        errorPlacement: function(error, element) {
            $(element).closest('div').addClass('has-error');
        }
    });
}
$(document).ready(function() {
	setFormValidation('#RegisterValidation');
	setFormValidation('#TypeValidation');
	setFormValidation('#LoginValidation');
	setFormValidation('#RangeValidation');
});
/*form wizard*/
$(document).ready(function() {
    demo.initMaterialWizard();
    setTimeout(function() {
        $('.card.wizard-card').addClass('active');
    }, 600);
});
/*table datatables*/
$(document).ready(function() {
    $('#datatables').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
        ],
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
        }

    });


    var table = $('#datatables').DataTable();

    // Edit record
    table.on('click', '.edit', function() {
        $tr = $(this).closest('tr');

        var data = table.row($tr).data();
        alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
    });

    // Delete a record
    table.on('click', '.remove', function(e) {
        $tr = $(this).closest('tr');
        table.row($tr).remove().draw();
        e.preventDefault();
    });

    //Like record
    table.on('click', '.like', function() {
        alert('You clicked on Like button');
    });

    $('.card .material-datatables label').addClass('form-group');
});


var readFile = function (input, destination) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(destination).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

var readFileProgress = function (input, destination, progressbar) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onloadstart = function (event) {
            $(progressbar).css("width", '0%');
        };
        reader.onprogress = function (event) {
            if (event.lengthComputable) {

                var percentLoaded = Math.round((event.loaded / event.total) * 100);

                if (percentLoaded <= 100) {
                    $(progressbar).css("width", percentLoaded + '%');
                }

                // Increase the progress bar length.

            }
        };


        reader.onload = function (e) {
            $(destination).attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
$('a.noty-confirm-del').click(function(e){
    e.preventDefault();    
    var url = $(this).attr('href');
    swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Yes",
        showLoaderOnConfirm: true
    }).then((result) => {
        if(result){
            window.location = url;           
        }
    });
});


