var i = 0;

function addVariante() {

    var min = $('#min').val();
    var max = $('#max').val();
    var unite = $('#unite option:selected').val();
    var sexe = $('#sexe option:selected').val();

    $('table > tbody').append(`
        <tr>
            <td>
                <input type='hidden' name='variantes[${i}][min]' value="${min}">${min}
            </td>
            <td>
                <input type='hidden' name='variantes[${i}][max]' value="${max}">${max}
            </td>
            <td>
                <input type='hidden' name='variantes[${i}][unite]' value="${unite}">${unite}
            </td>
            <td>
                <input type='hidden' name='variantes[${i}][sexe]' value="${sexe}">${sexe}
            </td>
            <td>
                <span class='glyphicon glyphicon-trash fa-2x' style='cursor:pointer;'></span>
            </td>
        </tr>`);
    i++;
    $('#min').val("");
    $('#max').val("");

}

$('table').on('click', '.glyphicon', function () { //function to remove field with fa close button
    $(this).parent().parent().remove();
});