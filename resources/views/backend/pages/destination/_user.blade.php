@extends('backend/layouts/template')

@section('title', 'User Destination Ticket')

@section('bread')
    <h2>User Destination Ticket</h2>
    <ol class="breadcrumb">
        <li><a href="{{ url('admin') }}">Dashboard</a></li>
        <li><a href="{{ url('admin/destination') }}">Destination</a></li>
        <li class="active"><strong>User</strong></li>
    </ol>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
@endsection

@section('main')

    <div class="row">
        <div class="col-lg-12">
            <div class="inqbox">
                <div class="inqbox-title border-top-success">
                    <h5>User Destination: {{ $detail->title }}</h5>
                    <br><br>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add_data_modal">
                        Tambah User
                    </button>
                </div>
                <div class="inqbox-content">
                    <div class="table-responsive">
                        <table id="tbl" class="table table-striped table-bordered table-hover dataTables-example">

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="add_data_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <form action="" id="insert_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Tambah User</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="text" name="oldMail" id="oldMail" style="display: none;" />
                                <input type="text" name="oldPassword" id="oldPassword" style="display: none;" />

                                <div class="form-group @if ($errors->has('name')) has-error @endif">
                                    <label class="control-label" for="name">Name user</label>
                                    <input id="name" name="name" type="text" class="form-control" placeholder="Name user"
                                        value="@if (count($errors)> 0) {{ old('name') }} @endif" />

                                    @if ($errors->has('name'))
                                        <span for="name" class="help-block">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="form-group @if ($errors->has('email')) has-error @endif">
                                    <label class="control-label" for="email">Email </label>
                                    <input id="email" type="text" name="email" class="form-control" placeholder="Email"
                                        value="@if (count($errors)> 0) {{ old('email') }} @endif" />

                                    @if ($errors->has('email'))
                                        <span for="email" class="help-block">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-group @if ($errors->has('password')) has-error @endif">
                                    <label class="control-label" for="password">Password </label>
                                    <input id="password" type="password" name="password" class="form-control"
                                        placeholder="Password" value="@if (count($errors)> 0) {{ old('password') }} @endif" />

                                    @if ($errors->has('password'))
                                        <span for="password" class="help-block">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('js')
    <script src="https://www.gstatic.com/firebasejs/8.7.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.6.8/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.6.8/firebase-auth.js"></script>

    <script src="{{ asset('assets/js/firekey.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        // firebase
        var idWisata = <?php echo $detail->destination_id; ?>;
        var database = firebase.database();

        getUserData();

        function getUserData() {
            var refUser = database.ref("user").orderByChild("idWisata").equalTo(idWisata);
            refUser.once('value', function(snapshot) {
                var dataset = [];
                snapshot.forEach(function(childSnapshot) {
                    var id = childSnapshot.key;
                    var email = childSnapshot.child("email").val();
                    var namaAdmin = childSnapshot.child("namaAdmin").val();

                    dataset.push([
                        email,
                        namaAdmin,
                        '<button class="btn btn-success dropdown-toggle btn-xs" onclick="editData(\'' +
                        id + '\')"><i class="fa fa-pencil"></i> Edit</button>',
                        '<button class="btn btn-danger dropdown-toggle btn-xs" onclick="editData(\'' +
                        id + '\')"><i class="fa fa-trash"></i> Hapus</button>'
                    ]);
                }) //endforeach

                table = $("#tbl").DataTable({

                    destroy: true,
                    dom: 'Bfrtip',
                    responsive: !0,
                    data: dataset,
                    columns: [{
                            title: "Email"
                        },
                        {
                            title: "Nama Admin"
                        },
                        {
                            title: "Edit"
                        },
                        {
                            title: "Hapus"
                        }
                    ],
                    buttons: [{
                        extend: "copy",
                        className: "btn-sm"
                    }, {
                        extend: "csv",
                        className: "btn-sm"
                    }, {
                        extend: "excel",
                        className: "btn-sm"
                    }, {
                        extend: "pdf",
                        className: "btn-sm"
                    }, {
                        extend: "print",
                        className: "btn-sm"
                    }]
                });
            }); //endrefuser
        }

        $('#insert_form').on("submit", function(event) {
            event.preventDefault();
            if ($('#email').val() == "") {
                alert("Harap isi email");
            } else if ($('#name').val() == "") {
                alert("Harap isi nama user");
            } else if ($('#password').val() == "") {
                alert("Harap isi password");
            } else {
                var email = $('#email').val();
                var namaAdmin = $('#name').val();
                var password = $('#password').val();
                var id = $('#id').val();
                var oldMail = $('#oldMail').val();
                var oldPassword = $('#oldPassword').val();

                if (id == "") {
                    addUser(email, namaAdmin, password);
                } else {
                    updateUser(email, namaAdmin, password, id, oldMail, oldPassword);
                }
            }
        })
        //end insert form

        function addUser(email, namaAdmin, password) {
            firebase.auth().createUserWithEmailAndPassword(email, password).then(function(user) {

                var user = firebase.auth().currentUser;

                var refUser = firebase.database().ref().child('user').push().set({
                    uid: user.uid,
                    email: email,
                    idWisata: idWisata,
                    namaAdmin: namaAdmin,
                    password: password
                });

                $('#insert_form')[0].reset();
                $('#add_data_modal').modal('hide');

                getUserData();


            }).catch(function(error) {
                var errorCode = error.code;
                var errorMessage = error.message;

                // [START_EXCLUDE]
                if (errorCode == 'auth/weak-password') {
                    alert('Password terlalu lemah.');
                } else {
                    alert(errorMessage);
                }
                console.log(error);
                // [END_EXCLUDE]
            });
            //end firebaseauth
        }

        function editData(id) {
            $('#add_data_modal').find('.modal-title').text('Edit User');
            $('#insert').val("Update");

            firebase.database().ref('user/' + id).once('value').then(function(snapshot) {
                var email = (snapshot.val() && snapshot.val().email);
                var namaAdmin = snapshot.val().namaAdmin;
                var password = snapshot.val().password;

                $('#email').val(email);
                $('#name').val(namaAdmin);
                $('#password').val(password);
                $('#id').val(id);
                $('#oldMail').val(email);
                $('#oldPassword').val(password);
            });
            $('#add_data_modal').modal('show');
        }

        function updateUser(email, namaAdmin, password, id, oldMail, oldPassword) {

            var refUser = firebase.database().ref().child('user/' + id).update({
                email: email,
                namaAdmin: namaAdmin,
                password: password
            });

            $('#insert_form')[0].reset();
            $('#add_data_modal').modal('hide');

            getUserData();
        }
    </script>

@endsection
