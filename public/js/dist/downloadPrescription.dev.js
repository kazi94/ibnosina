"use strict";

/*
 * download Prescription
 */
function downloadPrescription() {
  var p_id = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : null;
  var response = getData(p_id, "/patient/prescription/".concat(p_id, "/edit"));
  response.done(function (res) {
    downloadDocument(res);
  }).fail(function (err, type) {
    alert("Error : ".concat(err.responseText, " \n Type : ").concat(type));
  });
}