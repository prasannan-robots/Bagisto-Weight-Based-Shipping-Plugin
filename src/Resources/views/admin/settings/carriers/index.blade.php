
@extends('admin::layouts.content')

@section('page_title')
    {{ __('prasannacustomshipping::app.admin.settings.carriers.title') }}
@stop

@section('content')
    <div class="content">
        <form method="POST" action="{{ route('admin.settings.carriers.weight_based.store') }}" @submit.prevent="onSubmit">
            <div class="page-header">
                <div class="page-title">
                    <h1>
                        {{ __('prasannacustomshipping::app.admin.settings.carriers.title') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('admin::app.settings.carriers.save-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                <div class="form-container">
                    @csrf

                    <accordian :title="`{{ __('prasannacustomshipping::app.admin.settings.carriers.general') }}`" :active="true">
                        <div slot="body">
                            <div class="control-group">
                                <label for="title">{{ trans('admin::app.dashboard.index.title') }}</label>
                                <input type="text" class="control" id="title" name="title" value="{{ old('title') ?: core()->getConfigData('sales.carriers.weight_based.title') }}">
                            </div>

                            <div class="control-group">
                                <label for="description">{{ trans('admin::app.admin.system.description') }}</label>
                                <textarea class="control" id="description" name="description">{{ old('description') ?: core()->getConfigData('sales.carriers.weight_based.description') }}</textarea>
                            </div>

                            <div class="control-group">
                                <label for="rates">{{ __('prasannacustomshipping::app.admin.settings.carriers.rates') }}</label>
                                <input type="text" class="control" id="rates" name="rates" value="{{ old('rates') ?: core()->getConfigData('sales.carriers.weight_based.rates') }}">
                                <span class="control-info">{{ __('prasannacustomshipping::app.admin.settings.carriers.rates-info') }}</span>
                            </div>

                            <div class="control-group">
                                <label for="active">{{ trans('admin::app.admin.system.status') }}</label>
                                <label class="switch">
                                    <input type="checkbox" class="control" id="active" name="active" {{ core()->getConfigData('sales.carriers.weight_based.active') ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </accordian>
                </div>
            </div>
        </form>
    </div>
@stop
