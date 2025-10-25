<h3>Bulk SMS</h3>

<!-- Tabs -->
<ul class="nav nav-tabs" id="smsTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="send-tab" style="color: black !important;" data-bs-toggle="tab" data-bs-target="#send" type="button" role="tab">Send SMS</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="history-tab" style="color: black !important;" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">SMS History</button>
    </li>
</ul>

<div class="tab-content mt-3" id="smsTabContent">
    <!-- Send SMS Tab -->
    <div class="tab-pane fade show active" id="send" role="tabpanel">
        <form id="smsForm" method="POST" action="{{ route('bulk.sms') }}">
            @csrf

            <div class="form-group mb-3">
                <label>Select Client(s)</label>
                <select name="customer_ids[]" id="customerSelect" class="form-control" multiple required>
                    <option value="all">-- Select All Clients --</option>
                    @foreach($all_prices_details->pluck('customer')->unique('id') as $customer)
                        @if($customer && $customer->id)
                            <option value="{{ $customer->id }}">
                                {{ $customer->first_name }} {{ $customer->last_name }}
                            </option>
                        @endif
                    @endforeach
                </select>
                <small class="text-muted">Select multiple Clients or choose "Select All".</small>
            </div>
            @error('customer_ids')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <div class="form-group mb-3">
                <label>Message</label>
                <textarea name="message" id="message" rows="3" class="form-control" placeholder="Type your message..." required></textarea>
                <div class="text-muted mt-1" id="charCount">0 / 160 characters</div>
            </div>
            @error('message')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <div class="text-end">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-paper-plane"></i> Send SMS
                </button>
            </div>
        </form>
    </div>

    <!-- SMS History Tab -->
    <div class="tab-pane fade" id="history" role="tabpanel">
        <table class="table table-bordered" id="sms-history-table">
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Phone Number</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Sent At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bulksmsdata as $key => $sms)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ substr($sms->phone_number, 2) }}</td>
                        <td>{{ $sms->message }}</td>
                        <td>{{ ucfirst($sms->status) }}</td>
                        <td>{{ $sms->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
