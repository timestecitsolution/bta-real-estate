<div class="modal fade" id="visitpreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Visit Request Preview</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <strong>Full Name:</strong> <span id="full_name"></span>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Email:</strong> <span id="email"></span>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Phone:</strong> <span id="phone"></span>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Passport No:</strong> <span id="passport_no"></span>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>NID No:</strong> <span id="nid_no"></span>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Birth Certificate No:</strong> <span id="birth_certificate_no"></span>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Project:</strong> <span id="project_id"></span>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Flat:</strong> <span id="flat_id"></span>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>Preferred Date:</strong> <span id="preferred_date"></span>
                    </div>

                    <div class="col-md-12 mb-2">
                        <strong>Message:</strong>
                        <p id="message" class="border p-2 rounded"></p>
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>NID Front:</strong><br>
                        <img id="nid_front_pic" src="" class="img-fluid img-thumbnail" width="150">
                    </div>

                    <div class="col-md-6 mb-2">
                        <strong>NID Back:</strong><br>
                        <img id="nid_back_pic" src="" class="img-fluid img-thumbnail" width="150">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="printVisitPreview" class="btn btn-primary">Print</button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('printVisitPreview').addEventListener('click', function() {
    // Get modal content
    var content = document.querySelector('#visitpreviewModal .modal-body').innerHTML;

    // Open new window
    var printWindow = window.open('', '', 'height=600,width=800');

    // Write modal content
    printWindow.document.write('<html><head><title>Visit Request Preview</title>');
    // Optional: add Bootstrap CSS for proper styling
    printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">');
    printWindow.document.write('</head><body>');
    printWindow.document.write(content);
    printWindow.document.write('</body></html>');

    // Close document to finish loading
    printWindow.document.close();

    // Print
    printWindow.print();
});
</script>

