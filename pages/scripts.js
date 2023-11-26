$(document).ready(function () {
    $("#input-type").change(function () {
        var inputType = $(this).val();
        if (inputType === "dropdown") {
            $("#dropdown-options").show();
        } else {
            $("#dropdown-options").hide();
        }
    });

    $("#form-builder").submit(function (event) {
        event.preventDefault();
        var inputType = $("#input-type").val();
        var inputLabel = $("#input-label").val();
        var inputName = $("#input-name").val();

        var inputHtml = '';
        if (inputType === "dropdown") {
            var option1 = $("#option1").val();
            var option2 = $("#option2").val();
            inputHtml = `<label for="${inputName}">${inputLabel}</label><select name="${inputName}" id="${inputName}"><option value="${option1}">${option1}</option><option value="${option2}">${option2}</option></select>`;
        } else {
            inputHtml = `<label for="${inputName}">${inputLabel}</label><input type="${inputType}" name="${inputName}" id="${inputName}" required>`;
        }

        $("#dynamic-form").append(inputHtml);
        $(this).trigger("reset");
    });
});