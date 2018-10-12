/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *
 * haifahrul <haifahrul@gmail.com>
 */

$( document ).ready(function() {

    function clearForm(idForm) {
        $(idForm).modal("hide");
        $(idForm).on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
        });
    }

    function log(param) {
        console.log(param);
    }

    $("#print").on('click', function () {
        window.print();
        window.close();
    });

    $(document).on('click', '#modal-btn-view', function (e) {
        var url = $(this).attr("href");
        $("#modalform").modal("show").find("#modalContent").load(url);
        $('.modal-title').text(" $this->title ");
        e.preventDefault();
    });

    function deleteItems(url, confirmText, notif, alertText) {
        $(document).on("click", "#btn-delete-items", function () {
            var keys = $("#gridView").yiiGridView("getSelectedRows");
    //        log(keys);
            if (keys != "") {
                if (confirm(confirmText)) {
                    var keys = $("#gridView").yiiGridView("getSelectedRows");
                    $.ajax({
                        type: "post",
                        url: url,
                        data: {keys},
                        success: function (data) {
                            // $.pjax.reload({container: "#grid"});
                            location.reload();
                        }
                    });
                    return false;
                }
            } else {
                alert(alertText);
            }
        });
    }

    function drops(url, confirmText, notif, alertText) {
        $("#select-all").click(function () {
            $(".checkBoxClass").prop('checked', $(this).prop('checked'));
        });

        $(document).on("click", "#btn-drops", function () {
            var selected = [];

            $("input[name='select']:checked").each(function () {
                selected.push($(this).val());
            });

            if (selected == '') {
                alert(alertText);
            } else if (confirm(confirmText)) {
                $.ajax({
                    type: "post",
                    url: url,
                    data: {selected},
                    success: function (data) {
    //                    console.log(data);
    //                    if (data == 1) {
    //                        $.pjax.reload({container: "#grid"});
                            location.reload();
    //                        $.session.set('danger', notif);
    //                    }
                    },
                });

                return false;
            }
        });
    }

    function btnModal(id, title) {
        $(document).on('click', id, function (e) {
            var url = $(this).attr("href");
            $("#modal-form").modal("show").find("#modalContent").load(url);
            $('.modal-title').text(title);
            e.preventDefault();
        });
    }

    function dropdownEmpty(selector){
        selector.empty();
    }

    function enabledDropdown(selector) {
        selector.attr('disabled', false);
    }

    function disabledDropdown(selector) {
        selector.attr('disabled', true);
    }

    /* CREATE CAMPAIGN FORM */

    function validateCampaignCreateForm(arrField) {
        
        var isValid;

        $.each(arrField, function(index, value) {
            $('#campaign-create-form').yiiActiveForm('validateAttribute', 'campaign-' + value);
            // $('#campaign-create-form').yiiActiveForm('validateAttribute', 'campaign-' + value);
            // help-block help-block-error 
        });

        // $('<p class="help-block help-block-error"></p>').insertAfter('.input-group .file-caption-main');

        // $('#campaign-create-form').yiiActiveForm('validateAttribute', '.file-caption-name');

        // if ($('.file-caption-name').val() == '') {
        //     console.log('ok');
        // }

        $.each(arrField, function(index, value) {
            var isValidate = $(".field-campaign-" + value).attr("class");
            var hasSuccess = 'form-group field-campaign-' + value + ' required has-success';
            var hasSuccess2 = 'form-group field-campaign-' + value + ' has-success';
            var hasError = 'form-group field-campaign-' + value + ' required has-error';
            var hasError2 = 'form-group field-campaign-' + value + ' has-error';
            var required = 'form-group field-campaign-' + value + ' required';
            
            if (isValidate !== hasSuccess) {
                return isValid = false;
            // } else if (isValidate === hasError) {
                // return isValid = false;
            } else {
                return isValid = true;
            }
        });

        return isValid;
    }

    function campaignCreate() {

        var idStep1 = '#campaign-create-step-1';
        var idStep2 = '#campaign-create-step-2';
        var idStep3 = '#campaign-create-step-3';

        // initial hide form
        $(idStep2).hide();
        $(idStep3).hide();

        $('#btn-next-step-1').on('click', function (e) {
            var fieldStep1 = ['judul_campaign', 'target_donasi', 'deadline', 'kategori_id'];
            var isStep1Valid = validateCampaignCreateForm(fieldStep1);

            if (isStep1Valid) {
                $(idStep1).hide();
                $(idStep2).show();
            }
        });

        $('#btn-next-step-2').click(function() {
            var fieldStep2 = ['cover_image', 'upload_file', 'deskripsi_singkat', 'deskripsi_lengkap'];
            var isStep2Valid = validateCampaignCreateForm(fieldStep2);

            if (isStep2Valid) {
                $(idStep2).hide();
                $(idStep3).show();
            }
        });

        $("#btn-prev-step-1").click(function() {
            $(idStep1).show();
            $(idStep2).hide(); 
        });

        $("#btn-prev-step-2").click(function() {
            $(idStep2).show();
            $(idStep3).hide(); 
        });
    }

    campaignCreate();
});