@extends('frontEnd.layouts.master')

@section('content')

@php
    $commercialBrochure = $page_data->fields->where('field_id', 55)->first();
    $details = $page_data->details_en ?? '';

    // Decode HTML entities first (handles &lt;iframe&gt; stored in DB)
    $decoded = html_entity_decode($details, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    // Extract iframes, remove them from text flow
    $embeds = [];
    $detailsClean = preg_replace_callback(
        '/<iframe[^>]*>.*?<\/iframe>/is',
        function($matches) use (&$embeds) {
            $embeds[] = $matches[0];
            return '';
        },
        $decoded
    );

    $plainText = trim(strip_tags($detailsClean));
@endphp

{{-- ══════════════════════════════════
     SECTION 1 — BANNER + TITLE
══════════════════════════════════ --}}
<div class="social-activity-title-section">
    @if($page_data->photo)
        <img
            class="social-activity-banner-img"
            src="{{ URL::to('uploads/topics/'.$page_data->photo) }}"
            alt="{{ $page_data->title_en }}"
        >
    @elseif($page_data->photos->count() > 0)
        <img
            class="social-activity-banner-img"
            src="{{ URL::to('uploads/topics/'.$page_data->photos->first()->file) }}"
            alt="{{ $page_data->title_en }}"
        >
    @endif

    <div class="social-activity-banner-overlay"></div>

    <div class="social-activity-banner-content">
        <div class="container">
            <span class="social-activity-label">Social Activity</span>
            <h1>{{ $page_data->title_en }}</h1>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════
     SECTION 2 — DETAILS + VIDEO
══════════════════════════════════ --}}
<div class="social-activity-details-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-xl-8">
                <p class="section-heading">Social activity details</p>

                @if($plainText)
                    <p class="social-activity-details-text">{{ $plainText }}</p>
                @endif

                {{-- Embedded Videos (if any) --}}
                @foreach($embeds as $embed)
                    <div class="video-embed-wrapper">
                        {!! $embed !!}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<hr class="section-divider">

{{-- ══════════════════════════════════
     SECTION 3 — GALLERY
══════════════════════════════════ --}}
<div class="social-activity-gallery-section" id="gallery">
    <div class="container">

        <div class="gallery-heading-row">
            <h2>Gallery</h2>
            @if($page_data->photos->count() > 0)
                <span class="gallery-count">{{ $page_data->photos->count() }} photos</span>
            @endif
        </div>

        @if($page_data->photos->count() > 0)
            <div class="gallery-grid">
                @foreach($page_data->photos as $value)
                    <div class="gallery-item" onclick="openLightbox('{{ URL::to('uploads/topics/'.$value->file) }}')">
                        <img
                            src="{{ URL::to('uploads/topics/'.$value->file) }}"
                            alt="Gallery photo"
                            loading="lazy"
                        >
                    </div>
                @endforeach
            </div>
        @else
            <div class="gallery-empty">
                No photos available yet.
            </div>
        @endif
    </div>
</div>

{{-- ══════════════════════════════════
     LIGHTBOX
══════════════════════════════════ --}}
<div class="lightbox-overlay" id="lightbox" onclick="closeLightbox(event)">
    <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
    <img class="lightbox-img" id="lightbox-img" src="" alt="Full size photo">
</div>

<script>
    function openLightbox(src) {
        document.getElementById('lightbox-img').src = src;
        document.getElementById('lightbox').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox(e) {
        if (!e || e.target !== document.getElementById('lightbox-img')) {
            document.getElementById('lightbox').classList.remove('active');
            document.getElementById('lightbox-img').src = '';
            document.body.style.overflow = '';
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeLightbox();
    });
</script>

@endsection