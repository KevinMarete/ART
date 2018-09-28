
<style>
    .member{
        width: 300px;
    }
</style>
<form id="MINUTES">
    <div class="panel panel-default">
        <div class="panel-heading">Minutes - <?= date('d/m/Y') ?>  || <i class="fa fa-plus-circle loadUsers"> Template <select id='template'></select></i></div>
        <div class="panel-body" style="padding:20px;">
            <div class="row">
                <p><strong><input type="text" class="form-control" name="title" value="MINUTES OF PROCUREMENT PLANNING MEETING HELD AT NASCOP ON <?= date('d/m/Y'); ?> FROM 9.00 AM-2.00 PM" style="width:100%;"/></strong></p>
            </div>
            <p><strong>Members Present</strong></p>
            <p></p>
            <ol id="membersPresent">
                <li><input type="text" class="member" placeholder="Name -  Role" name="present_names[]"/>&nbsp;&nbsp;<input type="email" class="member" placeholder="Email" name="present_emails[]"/>&nbsp;&nbsp;<i class="fa fa-plus-circle addMemberPresent"></i></li>
            </ol>

            <p><strong>Absent with Apology</strong></p>
            <p></p>
            <ol id="membersAbsent">
                <li><input type="text" class="member" placeholder="Name -  Role" name="absent_names[]"/>&nbsp;&nbsp;<input type="email" class="member" placeholder="Email" name="absent_emails[]"/>&nbsp;&nbsp;<i class="fa fa-plus-circle addMemberAbsent"></i></li>
            </ol>

            <div class="row">
                <label>Describe how the meeting was initiated</label>
                <textarea name="" id="opening_description"  class="form-control" ></textarea>
            </div>

            <div class="row" style="margin-top:20px;">
                <p><strong>MINUTE 2: STOCK STATUS PER PRODUCT AND REQUIRED DELIVERIES AND NEW PROCUREMENTS</strong></p>
                <p><div class="alert alert-info">Please refer to Procurement > Meetings Menu***</div></p>
            </div> 
            <div class="row">
                <p><strong>A.O.B</strong></p>
                <textarea  name="aob" id="aob" class="form-control"></textarea>
            </div>
            <div class="row" style="display: none;">
                <textarea id="opening_description_" name="opening_description"></textarea>
                <textarea id="aob_" name="aob"></textarea>
            </div>
            <input type="button" id="saveMinute" class="btn btn-primary" style="margin-top: 20px;" value="Save Minute"/>
        </div>
    </div>
</form>

<script>
    $(function () {
        var lastURL = '<?= base_url(); ?>Manager/Procurement/loadLastMinutesHF';
        var mloaderURL = '<?= base_url(); ?>Manager/Procurement/loadLastMinutesBody';
        $("#template").empty();
        $('#template').append("<option value='<?= date('Y-m-d'); ?>'></option>")
        $.getJSON(lastURL, function (d) {
            $.each(d, function (index, cat) {
                $("#template").append($("<option value='" + cat.id + "'>" + cat.date.toUpperCase() + "</option>"));
            });
        });

        $('#template').change(function () {
            id = $(this).val();
            $.getJSON(mloaderURL + '/' + id, function (resp) {
                alert(resp.data);
                $('#opening_description').val(d[0].opening_description);
                $('#aob').val(d[0].aob);
            });
        });


        tinymce.init({selector: '#opening_description,#aob'});
        present = '<li style="margin-top:10px;"><input type="text" class="member" placeholder="Name -  Role" name="present_names[]"/>&nbsp;&nbsp;<input type="email" class="member" placeholder="Email" name="present_emails[]"/>&nbsp;&nbsp;<i class="fa fa-minus-circle remMemberPresent"></i></li>';
        absent = '<li style="margin-top:10px;"><input type="text" class="member" placeholder="Name -  Role" name="absent_names[]"/>&nbsp;&nbsp;<input type="email" class="member" placeholder="Email" name="absent_emails[]"/>&nbsp;&nbsp;<i class="fa fa-minus-circle remMemberAbsent"></i></li>';

        $('.addMemberPresent').click(function () {
            $('#membersPresent').append(present);
        });
        $(document).on('click', '.remMemberPresent', function () {
            $(this).closest('li').remove();
        });

        $(document).on('click', '.remMemberAbsent', function () {
            $(this).closest('li').remove();
        })

        $('.addMemberAbsent').click(function () {
            $('#membersAbsent').append(absent);
        });

        $('#saveMinute').click(function () {

            $('#opening_description_').val(tinymce.get('opening_description').getContent());
            $('#aob_').val(tinymce.get('aob').getContent());

            $.post("<?= base_url(); ?>Manager/Procurement/save_minutes/x", $('#MINUTES').serialize(), function () {

            }).done(function () {
                alert('Minutes Successfully Saved')
            });

            return false;
        });

    });
</script>