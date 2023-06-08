@extends('layouts.main')
@section('content')
    <form method="post" id="form">
        <input type="hidden" id="hidden_id" name="hidden_id">
        <div class="row">
            <div class="col">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required maxlength="50"
                       minlength="2">
                <div id="first_name_help" class="form-text">Please Enter Your First Name</div>
            </div>
            <div class="col">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required maxlength="50"
                       minlength="2">
                <div id="last_name_help" class="form-text">Please Enter Your Last Name</div>
            </div>
            <div class="col">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <div id="email_help" class="form-text">Please Enter Valid Email</div>
            </div>
            <div class="col">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="email" required minlength="6">
                <div id="password_help" class="form-text">Password Must Have Minimum 6 characters</div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="password" class="form-label">Please Select Gender </label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="gender_male" value="male" checked>
                    <label class="form-check-label" for="gender_male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="gender_female" value="female">
                    <label class="form-check-label" for="gender_female">Female</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="gender_unknown" value="unknown">
                    <label class="form-check-label" for="gender_unknown">Unknown</label>
                </div>
            </div>
            <div class="col">
                <label for="birthdate" class="form-label">Birth Date</label>
                <input type="text" class="form-control" id="birthdate" name="birthdate" required>
                <div id="birthdate_help" class="form-text">Select Your birthdate</div>
            </div>
            <div class="col">
                <label for="address" class="form-label">Address</label>
                <textarea name="address" id="address" required></textarea>
                <div id="address_help" class="form-text">Enter Your Address</div>
            </div>
            <div class="col">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone">
                <div id="phone_help" class="form-text">Enter Phone Number</div>
            </div>
        </div>
        <div>
            <div class="col">
                <input type="checkbox" class="form-check-input" id="rules" name="rules" checked>
                <label class="form-check-label" for="rules">I Accept The Rules </label>
            </div>
            <div class="col">
                <button type="button" class="btn btn-primary" id="add">Add To Table</button>
                <button type="button" class="btn btn-success" id="update">Update</button>
            </div>
        </div>

    </form>

    <hr/>

    <div class="input-group">
        <div class="form-outline">
            <input type="search" id="search" class="form-control" />
            <label class="form-label" for="search">Search</label>
        </div>
        <button type="button" class="btn btn-primary btn-search" id="btn-search">
            <i class="fas fa-search"></i>
        </button>
    </div>

    <div class="row">
        <table class="table table-bordered">
            <tr>
                <td>#</td>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Email</td>
                <td>Password</td>
                <td>Gender</td>
                <td>BirthDate</td>
                <td>Address</td>
                <td>Phone</td>
                <td></td>
            </tr>
        </table>
    </div>
@endsection
@push('scripts')
<script>
    let base_url = '<?= url('/api')  ?>';
    let itemCount = 1;
    let allItems = [];

    function deleteItem(id) {
        let del_url = base_url + "/patient/" + id;
        let c = confirm('Are You Sure To Delete Item ?');
        if (c) {
            $.ajax({
                url: del_url,
                type: 'DELETE',
                success: function (response) {
                    console.log(response);
                    allItems = response.data;
                    fillData();
                }
            });
        }
    }

    function fillForm(id) {
        console.log(id);
        let item = allItems.filter(function (element) {
            return element.id === id
        });
        item = item[0];
        console.log(item);
        $('#first_name').val(item.first_name);
        $('#last_name').val(item.last_name);
        $('#email').val(item.email);
        $('#password').val(item.password);
        $('input[name="gender"]').val(item.gender);
        $('#birthdate').val(item.birthdate);
        $('#address').val(item.address);
        $('#phone').val(item.phone);
        $('#hidden_id').val(id);
        $('#update').show();
        $('#add').hide();
    }

    function fillData() {
        $('.table').html('');
        let header = '<tr>\n' +
            '                <td>#</td>\n' +
            '                <td>First Name</td>\n' +
            '                <td>Last Name</td>\n' +
            '                <td>Email</td>\n' +
            '                <td>Password</td>\n' +
            '                <td>Gender</td>\n' +
            '                <td>BirthDate</td>\n' +
            '                <td>Address</td>\n' +
            '                <td>Phone</td>\n' +
            '                <td></td>\n' +
            '            </tr>';
        $('.table').append(header);
        allItems.forEach((element) => {
            let id = element.id;
            let name = element.first_name;
            let family = element.last_name;
            let email = element.email;
            let password = element.password;
            let gender = element.gender;
            let birthdate = element.birthdate;
            let address = element.address;
            let phone = element.phone;
            let item = {
                id,
                name,
                family,
                email,
                password,
                gender,
                birthdate,
                address,
                phone,
            };
            console.log(item);
            let text = '<tr data-id="' + id + '" >' +
                '<td>' + itemCount + '</td>' +
                '<td>' + name + '</td>' +
                '<td>' + family + '</td>' +
                '<td>' + email + '</td>' +
                '<td>***</td>' +
                '<td>' + gender + '</td>' +
                '<td>' + birthdate + '</td>' +
                '<td>' + address + '</td>' +
                '<td>' + phone + '</td>' +
                '<td>' +
                '<a href="#" class="fa fa-update" onclick="fillForm(' + id + ')" >update</a> ' +
                ' <a href="#" class="fa fa-delete" onclick="deleteItem(' + id + ')">remove</a>' +
                '</td>' +
                '</tr>';
            $('.table').append(text);
        });

    }

    $(document).ready(function () {
        readAllItems();
        $('#birthdate').datepicker({
            uiLibrary: 'bootstrap5'
        });
        $("#add").on("click", function (event) {
            let first_name = $('#first_name').val();
            let last_name = $('#last_name').val();
            let email = $('#email').val();
            let password = $('#password').val();
            let gender = $('input[name="gender"]:checked').val();
            let birthdate = $('#birthdate').val();
            let address = $('#address').val();
            let phone = $('#phone').val();
            let rules = $("#rules").is(':checked');
            if (rules) {
                let item = {first_name, last_name, email, password, gender, birthdate, address, phone};
                var settings = {
                    "url": base_url + "/patients",
                    "method": "POST",
                    "timeout": 0,
                    "headers": {
                        "Content-Type": "application/json"
                    },
                    "data": JSON.stringify(item),
                };

                $.ajax(settings).done(function (response) {
                    console.log(response);
                    allItems = response.data;
                    fillData();
                    emptyForm();
                });
            } else {
                alert('You Need Accept Rules');
            }
            event.preventDefault();
        });
        $("#update").on("click", function (event) {
            let id = $('#hidden_id').val();
            let first_name = $('#first_name').val();
            let last_name = $('#last_name').val();
            let email = $('#email').val();
            let password = $('#password').val();
            let gender = $('input[name="gender"]:checked').val();
            let birthdate = $('#birthdate').val();
            let address = $('#address').val();
            let phone = $('#phone').val();
            let rules = $("#rules").is(':checked');
            if (rules) {
                let item = {first_name, last_name, email, password, gender, birthdate, address, phone};
                var settings = {
                    "url": base_url + "/patient/"+id,
                    "method": "PUT",
                    "timeout": 0,
                    "headers": {
                        "Content-Type": "application/json"
                    },
                    "data": JSON.stringify(item),
                };

                $.ajax(settings).done(function (response) {
                    console.log(response);
                    allItems = response.data;
                    fillData();
                    emptyForm();
                });
            } else {
                alert('You Need Accept Rules');
            }
            event.preventDefault();
        });
        function emptyForm() {
            $('#first_name').val('');
            $('#last_name').val('');
            $('#email').val('');
            $('#password').val('');
            $('#birthdate').val('');
            $('#address').val('');
            $('#phone').val('');
        }
        function readAllItems() {
            $.get(base_url + "/patients", {})
                .done(function (response) {
                    console.log(response);
                    allItems = response.data;
                    fillData();
                });
        }
        $("#btn-search").on("click", function (event) {
            let name = $('#search').val();
            $.get(base_url + "/patients/search", {name})
                .done(function (response) {
                    console.log(response);
                    allItems = response.data;
                    fillData();
                });
            event.preventDefault();
        });
    });

</script>
@endpush
