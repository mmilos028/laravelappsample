<?php
//dd(get_defined_vars());
?>



<?php $__env->startSection('content'); ?>
    <script type="text/javascript">
        function copyParentEntityInformation(data){
            //console.log(data);
            if(data.user.first_name != ""){
                $("#first_name").val(data.user.first_name);
            }
            if(data.user.last_name != ""){
                $("#last_name").val(data.user.last_name);
            }
            if(data.user.mobile_phone != ""){
                $("#mobile_phone").val(data.user.mobile_phone);
            }
            if(data.user.email != ""){
                $("#email").val(data.user.email);
            }
            if (data.user.address != "") {
                $("#address").val(data.user.address);
            }
            if (data.user.commercial_address != "") {
                $("#commercial_address").val(data.user.commercial_address);
            }
            if (data.user.post_code != "") {
                $("#post_code").val(data.user.post_code);
            }
            if (data.user.city != "") {
                $("#city").val(data.user.city);
            }
            if (data.user.country_code != "") {
                $("#country").val(data.user.country_code);
            }
            if (data.user.language != "") {
                $("#language").val(data.user.language);
            }
        }

        function clearParentEntityInformation(){
            $("#first_name").val("");
            $("#last_name").val("");
            $("#mobile_phone").val("");
            $("#email").val("");
            $("#address").val("");
            $("#commercial_address").val("");
            $("#post_code").val("");
            $("#city").val("");
        }
    </script>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <i class="fa fa-user-plus"></i>
                <?php echo e(__("authenticated.New Entity")); ?>

                &nbsp;
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-user-plus"></i> <?php echo e(__("authenticated.Structure Entity")); ?></li>
                <li class="active">
                    <a href="<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/newStructureEntity2")); ?>" title="<?php echo e(__('authenticated.New Entity')); ?>">
                        <?php echo e(__("authenticated.New Entity")); ?>

                    </a>
                </li>
            </ol>
        </section>

        <section class="content">

            <!-- Form::open(array('url' => '/test/do-add-user'))  -->
            <div class="widget box col-md-4">
                <div class="widget-header" style="display: none;">
                    <h4>
                        <i class="fa fa-user-plus"></i>
                        <span><?php echo e(__("authenticated.New Entity")); ?></span>
                    </h4>
                </div>

                <div class="widget-content">
                    <?php echo Form::open(['url' => LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), 'user/new-user'),"id" => "newUserForm", 'method'=>'POST', 'class' => 'form-horizontal row-border' ]); ?>


                    <?php echo $__env->make('layouts.shared.form_messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <div id="alertFail" class="alert alert-danger" style="display:none"></div>
                    <div id="alertSuccess" class="alert alert-success" style="display:none"></div>

                    <div class="form-group required">
                        <label for="subject_type" class="col-md-3 control-label"><?php echo e(__ ("authenticated.Role")); ?>:</label>
                        <div class="col-md-4">
                            <select class="form-control" id="subject_type" name="subject_type">
                            </select>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label for="parent_affiliate" class="col-md-3 control-label"><?php echo e(__ ("authenticated.Parent Entity")); ?>:</label>
                        <div class="col-md-4">
                            <select name="parent_affiliate" id="parent_affiliate" class="form-control col-md-10">
                            </select>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label for="currency" class="col-md-3 control-label"><?php echo e(__ ("authenticated.Currency")); ?>:</label>
                        <div class="col-md-4">
                            <select class="form-control" id="currency" name="currency"></select>
                        </div>
                    </div>

                    <div class="form-group required" id="draw_model_container">
                        <label for="draw_model" class="col-md-3 control-label"><?php echo e(__ ("authenticated.Draw Model")); ?>:</label>
                        <div class="col-md-4">
                            <select name="draw_model" id="draw_model" class="form-control col-md-10">
                            </select>
                        </div>
                    </div>


                    <div class="form-group required">
                        <label id="usernameLabel" for="username" class="col-md-3 control-label"><?php echo e(__ ("authenticated.Username")); ?>:</label>
                        <div class="col-md-4">
                            <input class="form-control" placeholder="<?php echo e(__ ("authenticated.Username")); ?>" name="username" type="text" id="username" autofocus>
                        </div>
                    </div>

                    <div class="form-group required" id="passwordContainer">
                        <label id="passwordLabel" for="password" class="col-md-3 control-label"><?php echo e(__ ("authenticated.Password")); ?>:</label>
                        <div class="col-md-4">
                            <input class="form-control" placeholder="<?php echo e(__ ("authenticated.Password")); ?>" name="password" type="password" id="password">
                        </div>
                    </div>

                    <div class="form-group required" id="confirm_passwordContainer">
                        <label id="confirm_passwordLabel" for="confirm_password" class="col-md-3 control-label"><?php echo e(__ ("authenticated.Confirm Password")); ?>:</label>
                        <div class="col-md-4">
                            <input class="form-control" placeholder="<?php echo e(__ ("authenticated.Confirm Password")); ?>" name="confirm_password" type="password" value="" id="confirm_password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label id="first_nameLabel" for="first_name" class="col-md-3 control-label"><?php echo e(__ ("authenticated.First Name")); ?>:</label>
                        <div class="col-md-4">
                            <input class="form-control" placeholder="<?php echo e(__ ("authenticated.First Name")); ?>" name="first_name" type="text" id="first_name">
                        </div>
                    </div>

                    <div class="form-group" id="last_nameContainer">
                        <label for="last_name" class="col-md-3 control-label"><?php echo e(__ ("authenticated.Last Name")); ?>:</label>
                        <div class="col-md-4">
                            <input class="form-control" placeholder="<?php echo e(__ ("authenticated.Last Name")); ?>" name="last_name" type="text" id="last_name">
                        </div>
                    </div>

                    <div class="form-group required">
                        <label for="mobile_phone" class="col-md-3 control-label"><?php echo e(__ ("authenticated.Mobile Phone")); ?>:</label>
                        <div class="col-md-4">
                            <input class="form-control" placeholder="<?php echo e(__ ("authenticated.Mobile Phone")); ?>" name="mobile_phone" type="text" id="mobile_phone">
                        </div>
                    </div>

                    <div class="form-group required">
                        <label for="email" class="col-md-3 control-label"><?php echo e(__ ("authenticated.Email")); ?>:</label>
                        <div class="col-md-4">
                            <input class="form-control" placeholder="<?php echo e(__ ("authenticated.Email")); ?>" name="email" type="text" id="email">
                        </div>
                    </div>

                    <div id="div_form_group_address" class="form-group">
                        <label for="address" class="col-md-3 control-label"><?php echo e(__ ("authenticated.Address")); ?>:</label>
                        <div class="col-md-4">
                            <input class="form-control" placeholder="<?php echo e(__ ("authenticated.Address")); ?>" name="address" type="text" id="address">
                        </div>
                    </div>

                    <div id="div_form_group_commercial_address" class="form-group">
                        <label for="commercial_address" class="col-md-3 control-label"><?php echo e(__ ("authenticated.Address 2")); ?>:</label>
                        <div class="col-md-4">
                            <input class="form-control" placeholder="<?php echo e(__ ("authenticated.Address 2")); ?>" name="commercial_address" type="text" id="commercial_address">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="post_code" class="col-md-3 control-label"><?php echo e(__ ("authenticated.Post Code")); ?>:</label>
                        <div class="col-md-4">
                            <input id="post_code" class="form-control" placeholder="<?php echo e(__ ("authenticated.Post Code")); ?>" name="post_code" type="text">
                        </div>
                    </div>

                    <div id="div_form_group_city" class="form-group">
                        <label for="city" class="col-md-3 control-label"><?php echo e(__ ("authenticated.City")); ?>:</label>
                        <div class="col-md-4">
                            <input class="form-control" placeholder="<?php echo e(__ ("authenticated.City")); ?>" name="city" type="text" id="city">
                        </div>
                    </div>

                    <div class="form-group required">
                        <label for="country" class="col-md-3 control-label"><?php echo e(__ ("authenticated.Country")); ?>:</label>
                        <div class="col-md-4">
                            <select class="form-control" id="country" name="country"></select>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label for="language" class="col-md-3 control-label"><?php echo e(__ ("authenticated.Language")); ?>:</label>
                        <div class="col-md-4">
                            <select class="form-control" id="language" name="language"></select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button class="btn btn-primary" type="button" name="save" id="saveBtn"><i class="fa fa-save">&nbsp;</i><?php echo e(__ ("authenticated.Save")); ?></button>
                        <button class="btn btn-default" type="button" name="cancel" id="cancelBtn"><i class="fa fa-times">&nbsp;</i><?php echo e(__ ("authenticated.Cancel")); ?></button>
                    </div>

                    <?php echo Form::close(); ?>

                </div>
            </div>

        </section>
    </div>
    <script>
        $(document).ready(function(){
            var draw_model_types_array = ["<?php echo e(config('constants.CLIENT_TYPE_ID')); ?>", "<?php echo e(config('constants.OPERATER_TYPE_ID')); ?>", "<?php echo e(config('constants.LOCATION_TYPE_ID')); ?>"];

            var subject_id;
            var subject_type_id;
            var language;
            var country;
            var city;
            var post_code;
            var currency;
            var draw_model;

            function setDefaults(){
                $("#language").val(language);
                $("#country").val(country);
                $("#city").val(city);
                $("#post_code").val(post_code);
                document.getElementById("currency").value = currency;
            }

            function createNewUser(subject_type, parent_affiliate, username, password, confirm_password, first_name, last_name, mobile_phone, email, address,
                                   commercial_address, post_code, city, country, language, currency, draw_model){

                if(subject_type == "<?php echo e(config('constants.SELF_SERVICE_TERMINAL_ID')); ?>"){
                    password = username;
                    confirm_password = username;
                }

                $.ajax({
                    method: "GET",
                    url: "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "createNewStructureEntity")); ?>",
                    dataType: "json",
                    data: {
                        subject_type: subject_type,
                        parent_affiliate: parent_affiliate,
                        username: username,
                        password: password,
                        confirm_password: confirm_password,
                        first_name: first_name,
                        last_name: last_name,
                        mobile_phone: mobile_phone,
                        address: address,
                        email: email,
                        commercial_address: commercial_address,
                        post_code: post_code,
                        city: city,
                        country: country,
                        language: language,
                        currency: currency,
                        draw_model: draw_model

                    },
                    success: function(data){
                        if(data.status == "OK"){
                            $("#alertFail").empty();
                            $('#alertFail').hide();

                            $("#alertSuccess").empty();
                            $('#alertSuccess').show();

                            $('#alertSuccess').append('<p>'+data.message+'</p>');
                            $("html, body").animate({ scrollTop: 0 }, "fast");
                        }else{
                            $("#alertSuccess").empty();
                            $('#alertSuccess').hide();
                            $("#alertFail").empty();
                            $('#alertFail').show();

                            if(data.success){
                                jQuery('#alertFail').append('<p>'+data.message+'</p>');
                                $("html, body").animate({ scrollTop: 0 }, "fast");
                            }else{
                                jQuery.each(data.errors, function(key, value){
                                    jQuery('#alertFail').append('<p>'+value+'</p>');
                                    $("html, body").animate({ scrollTop: 0 }, "fast");
                                })
                            }
                        }
                    },
                    complete: function(data){

                    },
                    error: function(data){

                    }
                });
            }

            function listSubjectTypes(){
                $.ajax({
                    method: "GET",
                    url: "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "getSubjectRolesForNewStructureEntityForm")); ?>",
                    global: false,
                    dataType: "json",
                    //data: "result",
                    //"dataSrc": "result",
                    success: function(data){
                        if(data.status == "OK"){
                            var subjectTypeDropdown = document.getElementById("subject_type");
                            $.each(data.result, function(index, value){
                                var element = document.createElement('option');

                                element.value = value.subject_type_id;
                                element.textContent = value.subject_type_bo_name;

                                subjectTypeDropdown.appendChild(element);
                            });

                        }else if(data.status == -1){

                        }
                    },
                    complete: function(data){
                        subject_type_id = document.getElementById("subject_type").value;
                        getSubjectParents(subject_type_id);
                    },
                    error: function(data){

                    }
                });
            }
            function getSubjectParents(subject_type_id){
                $.ajax({
                    method: "GET",
                    url: "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/get-affiliates-from-role")); ?>",
                    global: false,
                    dataType: "json",
                    data: {
                        subject_type_id: subject_type_id
                    },
                    //"dataSrc": "result",
                    success: function(data){
                        if(data.status == "OK"){
                            var subjectsDropdown = document.getElementById("parent_affiliate");

                            $.each(data.list_affiliates, function(index, value){
                                var element = document.createElement('option');

                                element.value = value.subject_id_to;
                                element.textContent = value.subject_name_to;

                                subjectsDropdown.appendChild(element);
                            });

                        }else if(data.status == -1){
                        }
                    },
                    complete: function(data){
                        subject_id = document.getElementById("parent_affiliate").value;
                        getSubjectDetails(subject_id);

                        if(subject_type_id == draw_model_types_array[0] || subject_type_id == draw_model_types_array[1] || subject_type_id == draw_model_types_array[2]){
                            $("#draw_model_container").show();
                            getDrawModel(subject_id);
                        }else{
                            $("#draw_model_container").hide();
                        }


                    },
                    error: function(data){

                    }
                });
            }

            function listCountries(){
                $.ajax({
                    method: "GET",
                    url: "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "listCountries2")); ?>",
                    global: false,
                    dataType: "json",
                    //data: "result",
                    //"dataSrc": "result",
                    success: function(data){
                        if(data.status == "OK"){
                            var countryDropdown = document.getElementById("country");
                            $("#country").empty();

                            $.each(data.result, function(index, value){
                                var element = document.createElement('option');

                                element.value = value.country_code;
                                element.textContent = value.name;

                                countryDropdown.appendChild(element);
                            });

                        }else if(data.status == -1){

                        }
                    },
                    complete: function(data){
                        document.getElementById("country").value = country;
                    },
                    error: function(data){

                    }
                });
            }

            function listLanguages(){
                $.ajax({
                    method: "GET",
                    url: "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "getLanguagesAjax")); ?>",
                    global: false,
                    dataType: "json",
                    //data: "result",
                    //"dataSrc": "result",
                    success: function(data){
                        if(data.status == "OK"){
                            var languageDropdown = document.getElementById("language");
                            $("#language").empty();

                            $.each(data.result, function(index, value){
                                var element = document.createElement('option');

                                element.value = index;
                                element.textContent = value;

                                languageDropdown.appendChild(element);
                            });

                        }else if(data.status == -1){

                        }
                    },
                    complete: function(data){
                        document.getElementById("language").value = language;
                    },
                    error: function(data){

                    }
                });
            }

            function listCurrencies(){
                $.ajax({
                    method: "GET",
                    url: "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "listCurrencies")); ?>",
                    global: false,
                    dataType: "json",
                    //data: "result",
                    //"dataSrc": "result",
                    success: function(data){
                        if(data.status == "OK"){
                            var currencyDropdown = document.getElementById("currency");
                            $("#currency").empty();

                            $.each(data.result, function(index, value){
                                var element = document.createElement('option');

                                element.value = value.currency;
                                element.textContent = value.currency;

                                currencyDropdown.appendChild(element);
                            });

                        }else if(data.status == -1){

                        }
                    },
                    complete: function(data){
                        document.getElementById("currency").value = currency;
                        listDrawModels(currency);
                    },
                    error: function(data){

                    }
                });
            }

            function getSubjectDetails(subject_id){
                $.ajax({
                    url: "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "/administration/user-details")); ?>",
                    dataType: "json",
                    global: false,
                    data: {
                        user_id: subject_id
                    },
                    success: function(data){
                        language = data.user.language;
                        country = data.user.country_code;
                        city = data.user.city;
                        post_code = data.user.post_code;
                        currency = data.user.currency;
                        if(data.user.subject_type == "<?php echo config("constants.LOCATION_TYPE_NAME"); ?>") {
                            $("#currency").prop('disabled', true);
                        }else{
                            $("#currency").prop('disabled', false);
                        }

                        copyParentEntityInformation(data);

                        // if role is Cashier and changed selection of parent entity is location type, for new cashier copy-paste location informations
                        if($("#subject_type").val() == "<?php echo config("constants.TERMINAL_CASHIER_TYPE_ID"); ?>"){
                            if (data.user.address != "") {
                                $("#address").val(data.user.address);
                                //$("#address").attr("readonly", "readonly");
                            }
                            if (data.user.commercial_address != "") {
                                $("#commercial_address").val(data.user.commercial_address);
                            }
                            if (data.user.post_code != "") {
                                $("#post_code").val(data.user.post_code);
                            }
                            if (data.user.city != "") {
                                $("#city").val(data.user.city);
                            }
                            if (data.user.country_code != ""){
                                $("#country").val(data.user.country_code);
                            }

                            if(data.user.language != "") {
                                $("#language").val(data.user.language);
                            }
                        }
                    },
                    complete: function(xhr){
                        listCountries();
                        listCurrencies();
                        listLanguages();
                    },
                    fail: function(xhr){
                        console.error(xhr);
                    }
                });
            }

            function getDrawModel(affiliate_id){
                $.ajax({
                    method: "GET",
                    url: "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "getDrawModelForAff")); ?>",
                    global: false,
                    dataType: "json",
                    data: {
                        affiliate_id: affiliate_id
                    },
                    success: function(data){
                        draw_model = data.result;
                    },
                    complete: function(data){
                        document.getElementById("draw_model").value = draw_model;
                    },
                    error: function(data){

                    }
                });
            }

            function listDrawModels(currency){
                $.ajax({
                    method: "GET",
                    url: "<?php echo e(LaravelLocalization::getLocalizedURL(LaravelLocalization::getCurrentLocale(), "listDrawModelsForCurrency")); ?>",
                    global: false,
                    dataType: "json",
                    data: {
                        currency: currency,
                        active: false
                    },
                    //"dataSrc": "result",
                    success: function(data){

                        if(data.status == "OK"){
                            var count = data.count;
                            var drawModelDropdown = document.getElementById("draw_model");

                            $("#draw_model").empty();

                            if(count < 1){
                                var element = document.createElement('option');
                                element.value = null;
                                element.textContent = "<?php echo e(trans('authenticated.No active draw models')); ?>";

                                drawModelDropdown.appendChild(element);
                            }else{
                                $.each(data.result, function(index, value){
                                    var element = document.createElement('option');
                                    var control_free;

                                    if(value['draw_under_regulation'] == "<?php echo e(CONTROL); ?>"){
                                        control_free = "<?php echo e(trans('authenticated.Control')); ?>"+" (" + value['bet_win'] + " %)";
                                    }else{
                                        control_free = "<?php echo e(trans('authenticated.Free')); ?>";
                                    }

                                    element.value = value['draw_model_id'];
                                    element.textContent = value['draw_model'] + " - " + control_free;

                                    drawModelDropdown.appendChild(element);
                                });
                            }

                        }else if(data.status == -1){

                        }
                    },
                    complete: function(data){

                    },
                    error: function(data){

                    }
                });
            }

            //reset all values on form to empty
            function resetValuesOnForm(){
                $("#username").val("");
                $("#password").val("");
                $("#confirm_password").val("");
                $("#first_name").val("");
                $("#last_name").val("");
                $("#mobile_phone").val("");
                $("#email").val("");
                $("#address").val("");
                $("#commercial_address").val("");
                $("#post_code").val("");
                $("#city").val("");
            }

            listSubjectTypes();

            $("#subject_type").on("change", function(){
                resetValuesOnForm();

                var subject_type_id = document.getElementById("subject_type").value;

                if(subject_type_id == "<?php echo e(config('constants.SELF_SERVICE_TERMINAL_ID')); ?>"){
                    $("#usernameLabel").text("<?php echo e(trans('authenticated.MAC Address')); ?>");
                    $("#username").attr("placeholder", "<?php echo e(trans('authenticated.MAC Address')); ?>");

                    $("#first_nameLabel").text("<?php echo e(trans('authenticated.Self-service Terminal Name')); ?>");
                    $("#first_name").attr("placeholder", "<?php echo e(trans('authenticated.Self-service Terminal Name')); ?>");

                    $("#passwordContainer").hide();
                    $("#confirm_passwordContainer").hide();
                    $("#last_nameContainer").hide();
                }else{
                    $("#usernameLabel").text("<?php echo e(trans('authenticated.Username')); ?>");
                    $("#username").attr("placeholder", "<?php echo e(trans('authenticated.Username')); ?>");

                    $("#first_nameLabel").text("<?php echo e(trans('authenticated.First Name')); ?>");
                    $("#first_name").attr("placeholder", "<?php echo e(trans('authenticated.First Name')); ?>");

                    $("#passwordContainer").show();
                    $("#confirm_passwordContainer").show();
                    $("#last_nameContainer").show();
                }

                $("#parent_affiliate").empty();
                getSubjectParents(subject_type_id);

                $("#div_form_group_address").removeClass("required");
                $("#div_form_group_commercial_address").removeClass("required");
                $("#div_form_group_city").removeClass("required");

                var location_type_id = "<?php echo config("constants.LOCATION_TYPE_ID"); ?>";
                if(subject_type_id == location_type_id){
                    $("#div_form_group_address").addClass("required");
                    $("#div_form_group_commercial_address").addClass("required");
                    $("#div_form_group_city").addClass("required");
                }
            });

            $("#parent_affiliate").on("change", function(){
                var subject_id = document.getElementById("parent_affiliate").value;
                getSubjectDetails(subject_id);
            });
            $("#saveBtn").on("click", function(){
                var subject_type = document.getElementById("subject_type").value;
                var parent_affiliate = document.getElementById("parent_affiliate").value;
                var username = document.getElementById("username").value;
                var password = document.getElementById("password").value;
                var confirm_password = document.getElementById("confirm_password").value;
                var first_name = document.getElementById("first_name").value;
                var last_name = document.getElementById("last_name").value;
                var mobile_phone = document.getElementById("mobile_phone").value;
                var email = document.getElementById("email").value;
                var address = document.getElementById("address").value;
                var commercial_address = document.getElementById("commercial_address").value;
                var post_code = document.getElementById("post_code").value;
                var city = document.getElementById("city").value;
                var country = document.getElementById("country").value;
                var language = document.getElementById("language").value;
                var currency = document.getElementById("currency").value;
                var draw_model = document.getElementById("draw_model").value;

                createNewUser(subject_type, parent_affiliate, username, password, confirm_password, first_name, last_name, mobile_phone, email, address,
                    commercial_address, post_code, city, country, language, currency, draw_model);
            });

            $("#cancelBtn").on("click", function(){
                location.reload();
            });

            $("#currency").on("change", function(){
                var currency = $("#currency").val();

                listDrawModels(currency);
            });

            $.fn.select2.defaults.set("theme", "bootstrap");

            $('#country').select2();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make( $agent->isDesktop() ? 'layouts.desktop_layout' : 'layouts.mobile_layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>