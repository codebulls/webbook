$(document).ready(function(){

    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal-trigger').leanModal();
    $('select').material_select();
    $(".dropdown-button").dropdown();
    $('.collapsible').collapsible({
      accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
    });
    $('ul.tabs').tabs();
    // $('.datepicker').pickadate({
    //     selectMonths: true, // Creates a dropdown to control month
    //     monthsFull: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
    //     monthsShort: [ 'Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez' ],
    //     weekdaysShort: [ 'So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa' ],
    //     weekdaysFull: [ 'Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag' ],
    //     min: [1940,1,1],
    //     max: [1997,12,31],
    //     selectYears: 57,
    //     today: '',
    //     clear: 'Löschen',
    //     close: 'Übernehmen',
    //     labelMonthNext: 'zum nächsten Monat',
    //     labelMonthPrev: 'zum vorherigen Monat',
    //     labelMonthSelect: 'Wähle dem Monat aus dem Menu',
    //     labelYearSelect: 'Wähle das Jahr aus dem Menu'
    // });




    $('.cpacck').zclip({
        path:'js/ZeroClipboard.swf',
        copy:$('.acck').text()
    });


    $('#clearRegisterForm').click(function () {
        $('#registerForm').trigger("reset");
    });

    $('#clearAddUserForm').click(function() {
        $('#adminAddUser').trigger("reset");
    });

    $('#clearAddAdminForm').click(function () {
        $('#adminAddAdmin').trigger("reset");
    });

    $('#clearWebbookForm').click(function () {
        $('#pdfform').trigger("reset");
    });

    $('#checkAddAdminContent').click(checkAddAdminData);

    function checkAddAdminData()
    {
        var addadminform = $('#adminAddAdmin');
        var aapost = {
            'prefix':addadminform.find('input[name=aaprefix]:checked').val(),
            'firstname':$('#aafirst_name').val(),
            'lastname':$('#aalast_name').val(),
            'email':$('#aaemail').val(),
            'password':$('#aapassword').val()
        };


        $.post('checkadmindata', aapost, function(data) {
            var aao = $.parseJSON(data);
            if(aao.res == 'ok')
            {
                $('#formAddAdminConfirmTrigger').click();
                $('#checkAddAdminContent').parent().html('<button class="btn waves-effect waves-light fullsize teal accent-3 black-text" type="submit" id="checkContent" name="action" value="saveadmin">Speichern<i class="material-icons black-texst right">send</i></button>');
            }
            else
            {
                $('#confirmationAddAdminNotOk').html('');
                $('#confirmationAddAdminNotOk').append('<div class="modal-content">' +
                '<h4 class="red-text text-accent-4">Fehler bei Dateneingabe!</h4>' +
                '<p>Sie haben Ihre Daten unvollständig bzw. nicht korrekt eingegeben.</p>' +
                '<p>Bitte wiederholen Sie Ihre Eingaben und klicken Sie erneut auf <strong>"Daten prüfen"</strong>.</p>' +
                '<strong>Folgende Felder müssen überprüft werden:</<strong>' +
                '<table class="bordered" id="confirmationAddAdminTable"> ');

                $(aao).each(function(i,e) {
                    switch(e)
                    {
                        case 'prefix':
                            $('#confirmationAddAdminTable').append('<tr><td><strong>Anrede:</strong></td><td>Bitte wählen Sie eine Anrede aus.</td></tr>');
                            break;
                        case 'firstname':
                            $('#confirmationAddAdminTable').append('<tr><td><strong>Vorname:</strong></td><td>Bitte Vornamen eintragen.</td></tr>');
                            break;
                        case 'lastname':
                            $('#confirmationAddAdminTable').append('<tr><td><strong>Nachname:</strong></td><td>Bitte Nachnamen eintragen.</td></tr>');
                            break;
                        case 'email':
                            $('#confirmationAddAdminTable').append('<tr><td><strong>Email:</strong></td><td>Bitte Email überprüfen.</td></tr>');
                            break;
                        case 'password':
                            $('#confirmationAddAdminTable').append('<tr><td><strong>Passwort:</strong></td><td>Tragen Sie ein Passwort ein.</td></tr>');
                            break;
                        default:
                            break;
                    }
                });

                $('#confirmationAddAdminNotOk').append('</table>' +
               '</div>' +
               '<div class="modal-footer">' +
                    '<a href="#!" class=" modal-action modal-close waves-effect waves-red red lighten-1 btn">Schließen</a>' +
               '</div>');

                $('#failedAddAdminConfirm').click();
            }
        });
    }

    $('#checkAdminContent').click(checkAdminData);

    function checkAdminData() {
        var adduserform = $('#adminAddUser');
        var setactive = 0;
        if($('#setactive').prop('checked'))
        {
            setactive = 1;
        }

        var apost = {
            'tariff':$('#atariff option:selected').val(),
            'prefix':adduserform.find('input[name=aprefix]:checked').val(),
            'firstname':$('#afirst_name').val(),
            'lastname':$('#alast_name').val(),
            'email':$('#aemail').val(),
            'password':$('#apassword').val(),
            'street':$('#astreet').val(),
            'zip':$('#azip').val(),
            'city':$('#acity').val()
        };

        $.post('checkadduserdata', apost, function(data) {
            var ao = $.parseJSON(data);

            if(ao.res == 'ok')
            {
                $('#formAdminConfirmTrigger').click();
                $('#checkAdminContent').parent().html('<button class="btn waves-effect waves-light fullsize teal accent-3 black-text" type="submit" id="checkContent" name="action" value="save">Speichern<i class="material-icons right black-text">send</i></button>');
            }
            else
            {
                $('#confirmationAdminNotOk').html('');

                $('#confirmationAdminNotOk').append('<div class="modal-content">' +
                '<h4 class="red-text text-accent-4">Fehler bei Dateneingabe!</h4>' +
                '<p>Sie haben Ihre Daten unvollständig bzw. nicht korrekt eingegeben.</p>' +
                '<p>Bitte wiederholen Sie Ihre Eingaben und klicken Sie erneut auf <strong>"Daten prüfen"</strong>.</p>' +
                '<strong>Folgende Felder müssen überprüft werden:</<strong>' +
                '<table class="bordered" id="confirmationAdminTable"> ');

                $(ao).each(function(i,e) {
                    switch(e)
                    {
                        case 'tariff':
                            $('#confirmationAdminTable').append('<tr><td><strong>Tarif-Auswahl:</strong></td><td>Wählen Sie einen Tarif aus.</td></tr>');
                            break;
                        case 'firstname':
                            $('#confirmationAdminTable').append('<tr><td><strong>Vorname:</strong></td><td>Bitte Vornamen eintragen.</td></tr>');
                            break;
                        case 'lastname':
                            $('#confirmationAdminTable').append('<tr><td><strong>Nachname:</strong></td><td>Bitte Nachnamen eintragen.</td></tr>');
                            break;
                        case 'email':
                            $('#confirmationAdminTable').append('<tr><td><strong>Email:</strong></td><td>Bitte Email überprüfen.</td></tr>');
                            break;
                        case 'password':
                            $('#confirmationAdminTable').append('<tr><td><strong>Passwort:</strong></td><td>Tragen Sie ein Passwort ein.</td></tr>');
                            break;
                        case 'street':
                            $('#confirmationAdminTable').append('<tr><td><strong>Straße:</strong></td><td>Geben Sie eine Straße ein.</td></tr>');
                            break;
                        case 'zip':
                            $('#confirmationAdminTable').append('<tr><td><strong>PLZ:</strong></td><td>Geben Sie PLZ ein.</td></tr>');
                            break;
                        case 'city':
                            $('#confirmationAdminTable').append('<tr><td><strong>Stadt:</strong></td><td>Geben Sie Stadt ein.</td></tr>');
                            break;
                        default:
                            break;
                    }
                });

                $('#confirmationAdminNotOk').append('</table>' +
               '</div>' +
               '<div class="modal-footer">' +
                    '<a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Schließen</a>' +
               '</div>');

                $('#failedAdminConfirm').click();
            }
        });
    }

    $('#checkContent').click(checkData);

    function checkData() {

        var form = $('#registerForm');
        var agb = false;
        var wdr = false;
        if($('#agb').prop('checked'))
        {
            agb = true;
        }
        var post = {
            'tariff':$( "#tariff option:selected" ).val(),
            'prefix':form.find('input[name=prefix]:checked').val(),
            'firstname':$('#first_name').val(),
            'lastname':$('#last_name').val(),
            'email':$('#email').val(),
            'password':$('#password').val(),
            'street':$('#street').val(),
            'zip':$('#zip').val(),
            'city':$('#city').val(),
            'land':$('#land').val(),
            'agb':agb
        };

        $.post('checkdata', post, function (data) {
            var o = $.parseJSON(data);


            if(o.res == 'ok')
            {
                $('#formConfirmTrigger').click();

                $('#checkContent').parent().html('<button class="btn waves-effect waves-light fullsize teal accent-3 black-text" type="submit" id="checkContent" name="action" value="register">Registrieren<i class="material-icons black-text right">send</i></button>');
            }
            else
            {
                $('#confirmationNotOk').html('');

                $('#confirmationNotOk').append('<div class="modal-content">' +
                '<h4 class="red-text text-accent-4">Fehler bei Dateneingabe!</h4>' +
                '<p>Sie haben Ihre Daten unvollständig bzw. nicht korrekt eingegeben.</p>' +
                '<p>Bitte wiederholen Sie Ihre Eingaben und klicken Sie erneut auf <strong>"Daten prüfen"</strong>.</p>' +
                '<strong>Folgende Felder müssen überprüft werden:</<strong>' +
                '<table class="bordered" id="confirmationTable"> ');
                $(o).each(function(i,e){
                    switch (e)
                    {
                        case 'agb':
                            $('#confirmationTable').append('<tr><td><strong>AGB:</strong></td><td>Sie müssen den AGB zustimmen.</td></tr>');
                            break;
                        case 'password':
                            $('#confirmationTable').append('<tr><td><strong>Passwort:</strong></td><td>Überprüfen Sie Ihr Passwort.</td></tr>');
                            break;
                        case 'tariff':
                            $('#confirmationTable').append('<tr><td><strong>Tarif-Auswahl:</strong></td><td>Wählen Sie einen Tarif aus.</td></tr>');
                            break;
                        case 'firstname':
                            $('#confirmationTable').append('<tr><td><strong>Vorname:</strong></td><td>Bitte tragen Sie Ihren Vornamen ein.</td></tr>');
                            break;
                        case 'lastname':
                            $('#confirmationTable').append('<tr><td><strong>Nachname:</strong></td><td>Bitte tragen Sie Ihren Nachnamen ein.</td></tr>');
                            break;
                        case 'email':
                            $('#confirmationTable').append('<tr><td><strong>Email:</strong></td><td>Bitte eine gültige Email eintragen. Achten Sie auf Sonderzeichen.</td></tr>');
                            break;
                        case 'street':
                            $('#confirmationTable').append('<tr><td><strong>Anschrift/Straße:</strong></td><td>Bitte füllen Sie dieses Feld aus.</td></tr>');
                            break;
                        case 'zip':
                            $('#confirmationTable').append('<tr><td><strong>Plz:</strong></td><td>Bitte füllen Sie dieses Feld aus.</td></tr>');
                            break;
                        case 'city':
                            $('#confirmationTable').append('<tr><td><strong>Stadt/Ort:</strong></td><td>Bitte füllen Sie dieses Feld aus.</td></tr>');
                            break;
                        case 'land':
                            $('#confirmationTable').append('<tr><td><strong>Land:</strong></td><td>Bitte füllen Sie dieses Feld aus.</td></tr>');
                            break;
                        default:
                            break;
                    }

                });

               $('#confirmationNotOk').append('</table>' +
               '</div>' +
               '<div class="modal-footer">' +
                    '<a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Schließen</a>' +
               '</div>');

                $('#failedConfirm').click();
            }
        });


    }


    $('#checkPdfData').click(checkPdfForm);

    function checkPdfForm()
    {
        var form = $('#pdfform');

        var host = 'http://'+window.location.host;

        var post = {
            'projekt':$("#project option:selected").val(),
            'pdfname':$("#pdfname").val(),
            'pdffile':$("#pdffile").val()
        }

        $.post(host+'/webbook/checkFormData', post, function (data) {
            var o = $.parseJSON(data);

            if(o.res == 'ok')
            {
                $('#formConfirmTrigger').click();

                $('#checkPdfData').parent().html('<button class="btn waves-effect waves-light fullsize teal accent-3 black-text" type="submit" id="checkContent" name="action" value="wbcreate">Speichern<i class="material-icons black-text right">done</i></button>');
            }
            else
            {
                $('#confirmationNotOk').html('');

                $('#confirmationNotOk').append('<div class="modal-content">' +
                '<h4 class="red-text text-accent-4">Fehler bei Dateneingabe!</h4>' +
                '<p>Sie haben Ihre Daten unvollständig bzw. nicht korrekt eingegeben.</p>' +
                '<p>Bitte wiederholen Sie Ihre Eingaben und klicken Sie erneut auf <strong>"Daten prüfen"</strong>.</p>' +
                '<strong>Folgende Felder müssen überprüft werden:</<strong>' +
                '<table class="bordered" id="confirmationTable"> ');

                $(o).each(function(i,e){
                    switch (e)
                    {
                        case 'projekt':
                            $('#confirmationTable').append('<tr><td><strong>Projekt:</strong></td><td>Bitte geben Sie an, welchem Projekt das neue WebBook zugewiesen werden soll.</td></tr>');
                            break;
                        case 'pdfname':
                            $('#confirmationTable').append('<tr><td><strong>WebBook - Titel:</strong></td><td>Bitte tragen Sie einen Namen für das neue WebBook ein.</td></tr>');
                            break;
                        case 'pdffile':
                            $('#confirmationTable').append('<tr><td><strong>WebBook - Pdf:</strong></td><td>Bitte laden Sie eine Pdf-Datei hoch, die in ein WebBook konvertiert werden soll.</td></tr>');
                            break;
                        default:
                            break;
                    }
                });

                $('#confirmationNotOk').append('</table>' +
               '</div>' +
               '<div class="modal-footer">' +
                    '<a href="#!" class=" modal-action modal-close waves-effect waves-red btn-flat">Schließen</a>' +
               '</div>');

                $('#failedConfirm').click();
            }
        });
    }

});
