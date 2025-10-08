@php

  $sections = $page_data['sections'];

@endphp


@extends('frontEnd.layouts.master')

@section('content')


<section class="project-wrap">
    <div class="container">
      <div class="custom-tabs">
        <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
            @foreach($sections as $key => $section)
                @php
                    $tabId = 'section_' . $section['id']; // safe id
                @endphp
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if($key === 0) active @endif"
                            id="{{ $tabId }}-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#{{ $tabId }}"
                            type="button" role="tab">
                        {{ $section['title_en'] }}
                    </button>
                </li>
            @endforeach
        </ul>

        <div class="tab-content" id="myTabContent">
            @foreach($sections as $key_l => $section)
                @php
                    $tabId = 'section_' . $section['id'];
                    $projects = Helper::Topics(8, $section['id']);

                @endphp
                <div class="tab-pane fade @if($key_l === 0) show active @endif"
                     id="{{ $tabId }}"
                     role="tabpanel"
                     aria-labelledby="{{ $tabId }}-tab">
                    <div class="row">
                        @foreach($projects as $project)
                            <div class="col-lg-4">
                                <div class="inner-project-single">
                                    <img src="{{ URL::to('uploads/topics/'.$project['photo_file']) }}" alt="">
                                    <h3>{{ $project['title_en'] }}</h3>
                                    <p>{!! substr($project['seo_description_en'], 0, 150) . '...' !!}</p>
                                    <a href="{{ route('details', $project['id']) }}" class="btn btn-primary">View Details <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    </div>
  </section>

@endsection