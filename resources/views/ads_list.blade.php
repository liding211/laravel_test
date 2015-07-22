<!DOCTYPE html>

@extends('layouts.main')

@section('title', 'List of ads')

@section('style')
    <style type="text/css">
        .ad{
            cursor: pointer;
        }
        .modal-box {
            display: none;
            position: absolute;
            z-index: 1000;
            width: 98%;
            background: white;
            border-bottom: 1px solid #aaa;
            border-radius: 4px;
            box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(0, 0, 0, 0.1);
            background-clip: padding-box;
        }

        .modal-box header,
        .modal-box .modal-header {
            padding: 1.25em 1.5em;
            border-bottom: 1px solid #ddd;
        }

        .modal-box header h3,
        .modal-box header h4,
        .modal-box .modal-header h3,
        .modal-box .modal-header h4 { margin: 0; }

        .modal-box .modal-body { padding: 2em 1.5em; }

        .modal-box footer,
        .modal-box .modal-footer {
            padding: 1em;
            border-top: 1px solid #ddd;
            background: rgba(0, 0, 0, 0.02);
            text-align: right;
        }

        .modal-overlay {
            opacity: 0;
            filter: alpha(opacity=0);
            position: absolute;
            top: 0;
            left: 0;
            z-index: 900;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3) !important;
        }

        a.close {
            line-height: 1;
            font-size: 1.5em;
            position: absolute;
            top: 5%;
            right: 2%;
            text-decoration: none;
            color: #bbb;
        }

        a.close:hover {
            color: #222;
            -webkit-transition: color 1s ease;
            -moz-transition: color 1s ease;
            transition: color 1s ease;
        }
        
        @media (min-width: 32em) {
            .modal-box { width: 70%; }
        }
    </style>
@show

@section('content')
    <div class="ads_list">
        Sort by: <a href="<?= url('ads_sort', ['order' => 'asc']) ?>">ASC</a> | <a href="<?= url('ads_sort', ['order' => 'desc']); ?>">DESC</a>
        
        @foreach ($ads as $ad)
            <div class="ad" id="{{ $ad->id }}">{{ $ad->title }}</div>
        @endforeach
        
        @if($ads->hasPages())
            @if( $ads->previousPageUrl() )
                <a href="<?= $ads->previousPageUrl(); ?>">Prev</a>
            @endif
            @if( $ads->nextPageUrl() )
                <a href="<?= $ads->nextPageUrl(); ?>">Next</a>
            @endif
        @endif
    </div>
    <div id="popup" class="modal-box">  
        <header>
            <a href="#" class="js-modal-close close">×</a>
            <h3>Title</h3>
        </header>
        <div class="modal-body-container">
            <div class="modal-body"></div>
            <div class="modal-img"></div>
        </div>
        <footer>
            <a href="#" class="js-modal-close">Close Button</a>
        </footer>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.ad').click(function(){            
                $.ajax({
                    url: '<?= url("show_details"); ?>',
                    type: 'post',
                    dataType: 'json',
                    data: {'id' : this.id, '_token': '{{ csrf_token() }}'},
                    success: function(data){
                        
                        $('.modal-box > header > h3').html('');
                        $('.modal-body').html('');
                        $('.modal-img').html('');
                        
                        $('.modal-box > header > h3').html( data.title );
                        $('.modal-body').html( data.text );
                        if(data.image != null && data.image != ''){
                            $('.modal-img').html( 
                                '<img src="<?= url("upload/images") ?>/' + data.image + '"/>' 
                            );
                        }
                        $('.modal-box').show();
                    }
                });      
            }); 
            $('.js-modal-close').click(function(){
                $('.modal-box').hide();
            }); 
        });
    </script>
@endsection