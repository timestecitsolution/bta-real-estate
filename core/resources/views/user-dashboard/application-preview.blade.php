<div class="modal fade" id="applicationPreviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Application Preview</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body" id="printArea">

                <div class="text-center mb-3">
                    <h4>Building Technology Architecture</h4>
                    <hr>
                </div>
                <div class="row application-header">
                    <div class="col-6 left-info">
                        <p><strong>Date:</strong> <span id="previewDate"></span></p>
                        <p><strong>Subject:</strong> <span id="previewSubject"></span></p>
                    </div>
                    <div class="col-6 right-info">
                        <p class="text-end status-box"><strong>Status:</strong> <span id="status"></span></p>
                    </div>
                </div>
                <hr>
                <div id="previewBody" class="application-body"></div>
                <br>
                <p>
                    Yours sincerely,<br>
                    <strong>{{ $user->name }}</strong>
                </p>
                <div id="feedbackSection" style="display:none;">
                    <hr>
                    <h6>Feedback History</h6>
                    <div id="previewFeedback"></div>
                </div>
                <div id="feedbackReplySection" class="mt-3 no-print">

                    <hr>
                    <h6>Reply</h6>

                    <form id="feedbackReplyForm">
                        @csrf
                        <input type="hidden" name="application_id" id="feedbackApplicationId">
                        <div class="form-group">
                            <textarea
                                class="form-control"
                                name="feedback"
                                id="feedbackText"
                                rows="3"
                                placeholder="Write your reply here..."
                                required
                            ></textarea>
                        </div>

                        <div class="text-right mt-2">
                            <button type="submit" class="btn btn-primary btn-sm">
                                💬 Reply
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-success" onclick="printApplication()">🖨 Print</button>
            </div>

        </div>
    </div>
</div>
<style>
.status-box {
    text-align: right;
}

/* PRINT FIX */
@media print {
    .application-header {
        display: flex !important;
        width: 100%;
    }

    .application-header .left-info {
        width: 60%;
    }

    .application-header .right-info {
        width: 40%;
        text-align: right;
    }
    .no-print {
        display: none !important;
    }
}
</style>
<script>
    $('#feedbackReplyForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: "{{ route('application.feedback.store') }}",
        type: "POST",
        data: $(this).serialize(),
        success: function (res) {

            $('#feedbackText').val('');
            $('#previewFeedback').append(`
                <div class="feedback-row feedback-right">
                    <div class="feedback-bubble feedback-user">
                        <strong>You</strong><br>
                        <small class="text-muted">Just now</small>
                        <div style="margin-top:6px;">
                            ${res.feedback}
                        </div>
                    </div>
                </div>
            `);

            $('#feedbackSection').show();
        },
        error: function () {
            alert('Failed to submit feedback');
        }
    });
});

function printApplication() {
    let printContents = document.getElementById('printArea').innerHTML;
    let originalContents = document.body.innerHTML;

    document.body.innerHTML = `
        <html>
            <head>
                <title>Print Application</title>
                <style>
                    body {
                        font-family: 'Times New Roman';
                        padding: 30px;
                        line-height: 1.8;
                    }
                    h4 {
                        margin-bottom: 10px;
                    }
                    hr {
                        margin: 15px 0;
                    }
                </style>
            </head>
            <body>
                ${printContents}
            </body>
        </html>
    `;

    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}

</script>

