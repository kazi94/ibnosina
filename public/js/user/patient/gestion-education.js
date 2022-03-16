/**
 * on submit education form
 * @param {Event} e 
 */
function downloadEducation(e) {
    if (confirm('Voulez vous une copie du rapport de l\'éducation thérapeutique?')) {
        const notes = $("#modal_entretien").find("textarea[name='notes']").val();
        const date_educ = new Date().toISOString().slice(0, 10);
        lunchDownloadEduc(date_educ, notes);
    }
}
$("#formEducation").on('submit', downloadEducation)

function lunchDownloadEduc(date_educ, notes) {

    text = {
        head: [
            'Date : ' + date_educ + '\n'
        ],
        core: [{
                text: 'Rapport Education Thérapeutique',
                style: 'header',
                alignment: 'center'
            },
            {
                style: 'core',
                text: notes,
            },
        ]
    };
    downloadDocument(text, 'Education-Thérapeutique-' + new Date().toISOString().slice(0, 10) + ".pdf");
}

function preDownloadEduc() {
    const date_educ = $(this).data('date');
    const notes = $(this).data('notes');
    lunchDownloadEduc(date_educ, notes);
}
$(".download-education").on('click', preDownloadEduc);