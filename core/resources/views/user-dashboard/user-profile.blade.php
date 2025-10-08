<div class="container mt-4">
    <div class="row">
        {{-- Profile Photo --}}
        <div class="col-md-4 text-center">
            <div class="avatar mb-3">
                <img src="{{ asset('uploads/contacts/' . ($Contact->photo ?? 'profile.jpg')) }}" 
                     alt="Profile Photo" class="img-fluid rounded-circle" style="width:200px; height:200px;">
            </div>
            <h4>{{ $Contact->first_name }} {{ $Contact->last_name }}</h4>
            <p>Phone: {{ $Contact->phone }}</p>
        </div>

        {{-- Profile Details --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success">
                    <h5 class="text-white">Profile Details</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Full Name</th>
                            <td>{{ $Contact->first_name }} {{ $Contact->last_name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $Contact->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $Contact->phone }}</td>
                        </tr>
                        @if($Contact->nid_no)
                        <tr>
                            <th>NID Number</th>
                            <td>{{ $Contact->nid_no ?? '-' }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>NID Front</th>
                            <td>
                                @if(!empty($Contact->nid_front))
                                    <a href="{{ asset('uploads/contacts/' . $Contact->nid_front) }}" download>
                                        <img src="{{ asset('uploads/contacts/' . $Contact->nid_front) }}" 
                                            alt="NID Front" 
                                            class="img-thumbnail" 
                                            style="max-width:120px;">
                                    </a>
                                @else
                                    <span class="text-muted">Not uploaded</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>NID Back</th>
                            <td>
                                @if(!empty($Contact->nid_back))
                                    <a href="{{ asset('uploads/contacts/' . $Contact->nid_back) }}" download>
                                        <img src="{{ asset('uploads/contacts/' . $Contact->nid_back) }}" 
                                            alt="NID Back" 
                                            class="img-thumbnail" 
                                            style="max-width:120px;">
                                    </a>
                                @else
                                    <span class="text-muted">Not uploaded</span>
                                @endif
                            </td>
                        </tr>
                        @if($Contact->passport_no)
                        <tr>
                            <th>Passport Number</th>
                            <td>{{ $Contact->passport_no ?? '-' }}</td>
                        </tr>
                        @endif
                        @if($Contact->birth_certificate_no)
                        <tr>
                            <th>Birth Certificate Number</th>
                            <td>{{ $Contact->birth_certificate_no ?? '-' }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
