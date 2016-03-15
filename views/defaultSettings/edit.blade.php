@section('page_title')
    <h2>{{xe_trans('board::boardDetailConfigures')}}</h2>
@endsection

@section('page_description')
@endsection

{{ XeFrontend::js('plugins/board/assets/js/managerSkin.js')->load() }}

<!-- Main content -->
<section class="content __xe_sections bbbb">
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <!-- Board config boxx -->
    <div class="panel">
        <div class="panel-heading">
            <div class="row">
                <p class="txt_tit">{{xe_trans('board::boardDetailConfigures')}}</p>

                <div class="right_btn pull-right" role="button" data-toggle="collapse" data-parent="#accordion" data-target="#boardSection">
                    <!-- [D] 메뉴 닫기 시 버튼 클래스에 card_close 추가 및 item_container none/block 처리-->
                    <button class="btn_clse ico_gray pull-left"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="blind">{{xe_trans('xe::menuClose')}}</span></button>
                </div>
            </div>
        </div>
        <div id="boardSection" class="panel-collapse collapse in" role="tabpanel">
            <div class="panel-body panel-collapse collapse in">
            <form method="post" id="board_manage_form" action="{!! $urlHandler->managerUrl('update', ['boardId' => $boardId]) !!}">

                <input type="hidden" name="_token" value="{{{ Session::token() }}}">

                <div class="form-group">
                    <label for="">{{xe_trans('board::perPage')}}</label>
                    <label><input type="checkbox" class="inheritCheck" data-target="perPage" @if($config->getPure('perPage') == null) checked="checked" @endif />{{ xe_trans('xe::inheritMode') }}</label>
                    <p class="desc-text">{{xe_trans('board::perPageDescription')}}</p>
                    <input type="text" id="" name="perPage" class="form-control" value="{{Input::old('perPage', $config->get('perPage'))}}" @if($config->getPure('perPage') == null) disabled="disabled" @endif/>
                </div>

                <div class="form-group">
                    <label for="">{{xe_trans('board::newArticleTime')}}</label>
                    <label><input type="checkbox" class="inheritCheck" data-target="newTime" @if($config->getPure('newTime') == null) checked="checked" @endif />{{ xe_trans('xe::inheritMode') }}</label>
                    <p class="desc-text">{{xe_trans('board::newArticleTimeDescription')}}</p>
                    <input type="text" id="" name="newTime" class="form-control" value="{{Input::old('newTime', $config->get('newTime'))}}" @if($config->getPure('newTime') == null) disabled="disabled" @endif/>
                </div>

                <div class="form-group">
                    <label for="">{{xe_trans('xe::comment')}}</label>
                    <label><input type="checkbox" class="inheritCheck" data-target="comment" @if($config->getPure('comment') == null) checked="checked" @endif />{{ xe_trans('xe::inheritMode') }}</label>
                    <select id="" name="comment" class="form-control" @if($config->getPure('comment') == null) disabled="disabled" @endif>
                        <option value="true" {!! $config->get('comment') == true ? 'selected="selected"' : '' !!} >Use</option>
                        <option value="false" {!! $config->get('comment') == false ? 'selected="selected"' : '' !!} >Disuse</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">{{xe_trans('xe::recommend')}}</label>
                    <label><input type="checkbox" class="inheritCheck" data-target="assent" @if($config->getPure('assent') == null) checked="checked" @endif />{{ xe_trans('xe::inheritMode') }}</label>
                    <select id="" name="assent" class="form-control" @if($config->getPure('assent') == null) disabled="disabled" @endif>
                        <option value="true" {!! $config->get('assent') == true ? 'selected="selected"' : '' !!} >Use</option>
                        <option value="false" {!! $config->get('assent') == false ? 'selected="selected"' : '' !!} >Disuse</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">{{xe_trans('xe::discommend')}}</label>
                    <label><input type="checkbox" class="inheritCheck" data-target="dissent" @if($config->getPure('dissent') == null) checked="checked" @endif />{{ xe_trans('xe::inheritMode') }}</label>
                    <select id="" name="dissent" class="form-control" @if($config->getPure('dissent') == null) disabled="disabled" @endif>
                        <option value="true" {!! $config->get('dissent') == true ? 'selected="selected"' : '' !!} >Use</option>
                        <option value="false" {!! $config->get('dissent') == false ? 'selected="selected"' : '' !!} >Disuse</option>
                    </select>
                </div>

                <div class="form-group form-category-select">
                    <label for="">{{xe_trans('xe::category')}}</label>
                    <label><input type="checkbox" class="inheritCheck" data-target="category" @if($config->getPure('category') == null) checked="checked" @endif />{{ xe_trans('xe::inheritMode') }}</label>
                    <select id="" name="category" class="form-control" @if($config->getPure('category') == null) disabled="disabled" @endif data-id="{{ $config->get('categoryId') }}" data-url="{{route('manage.board.board.storeCategory', ['boardId' => $config->get('boardId')])}}">
                        <option value="true" {!! $config->get('category') == true ? 'selected="selected"' : '' !!} >Use</option>
                        <option value="false" {!! $config->get('category') == false ? 'selected="selected"' : '' !!} >Disuse</option>
                    </select>
                    <button type="button" data-href="{{ route('manage.category.show', ['id' => '']) }}" @if($config->get('category') === false) disabled="disabled" @endif>{{xe_trans('xe::categoryManage')}}</button>
                </div>

                <div class="form-group">
                    <label for="">{{xe_trans('board::anonymityUse')}}</label>
                    <label><input type="checkbox" class="inheritCheck" data-target="anonymity" @if($config->getPure('anonymity') == null) checked="checked" @endif />{{ xe_trans('xe::inheritMode') }}</label>
                    <select id="" name="anonymity" class="form-control" @if($config->getPure('anonymity') == null) disabled="disabled" @endif>
                        <option value="true" {!! $config->get('anonymity') == true ? 'selected="selected"' : '' !!} >Use</option>
                        <option value="false" {!! $config->get('anonymity') == false ? 'selected="selected"' : '' !!} >Disuse</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">{{xe_trans('board::anonymityName')}}</label>
                    <label><input type="checkbox" class="inheritCheck" data-target="anonymityName" @if($config->getPure('anonymityName') == null) checked="checked" @endif />{{ xe_trans('xe::inheritMode') }}</label>
                    <p class="desc-text">{{xe_trans('board::anonymityDescription')}}</p>
                    <input type="text" name="anonymityName" class="form-control" @if($config->getPure('anonymityName') == null) disabled="disabled" @endif value="{{ Input::old('anonymityName', $config->get('anonymityName')) }}" />
                </div>

                <div class="form-group">
                    <label for="">{{xe_trans('board::adminEmail')}}</label>
                    <label><input type="checkbox" class="inheritCheck" data-target="managerEmail" @if($config->getPure('managerEmail') == null) checked="checked" @endif />{{ xe_trans('xe::inheritMode') }}</label>
                    <p class="desc-text">{{xe_trans('board::adminEmailDescription')}}</p>
                    <input type="text" name="managerEmail" class="form-control" @if($config->getPure('managerEmail') == null) disabled="disabled" @endif value="{{ Input::old('managerEmail', $config->get('managerEmail')) }}" />
                </div>

                <div class="form-group">
                    <label for="">{{xe_trans('xe::list')}}</label>
                    <label><input type="checkbox" class="inheritCheck" data-select=".listColumns" @if($config->getPure('listColumns') == null) checked="checked" @endif />{{ xe_trans('xe::inheritMode') }}</label>
                    <div class="form-inline listColumns">
                        <div class="form-group">
                            <select class="form-control" id="list_options" size="8" multiple="multiple">
                                @foreach ($listOptions as $columnName)
                                    <option value="{{$columnName}}">{{$columnName}}</option>
                                @endforeach
                            </select>
                            <div>
                                <button type="button" class="btn btn-default list-option-add">추가</button>
                            </div>

                        </div>
                        <div class="form-group">
                            <select class="form-control" id="list_selected" size="8" multiple="multiple" @if($config->getPure('listColumns') == null) disabled="disabled" @endif>
                                @foreach ($listColumns as $columnName)
                                    <option value="{{$columnName}}">{{$columnName}}</option>
                                @endforeach
                            </select>
                            <div>
                                <button type="button" class="btn btn-default list-option-up">위로</button>
                                <button type="button" class="btn btn-default list-option-down">아래로</button>
                                <button type="button" class="btn btn-default list-option-delete">삭제</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="">{{xe_trans('xe::input')}}</label>
                    <label><input type="checkbox" class="inheritCheck" data-select=".formColumns" @if($config->getPure('formColumns') == null) checked="checked" @endif />{{ xe_trans('xe::inheritMode') }}</label>
                    <div class="form-group formColumns">
                        <select class="form-control" id="form_order" size="8" multiple="multiple" @if($config->getPure('formColumns') == null) disabled="disabled" @endif>
                            @foreach ($formColumns as $columnName)
                                <option value="{{$columnName}}">{{$columnName}}</option>
                            @endforeach
                        </select>
                        <div>
                            <button type="button" class="btn btn-default form-order-up">위로</button>
                            <button type="button" class="btn btn-default form-order-down">아래로</button>
                        </div>
                    </div>
                </div>

                <!-- Permission -->
                @foreach ($perms as $perm)
                    <div class="form-group">
                        <label for="">{{ $perm['title'] }} {{xe_trans('xe::permission')}}</label>
                        <div class="well">
                            {!! uio('permission', $perm) !!}
                        </div>
                    </div>
                @endforeach

                <button type="submit" class="btn btn-primary">{{xe_trans('xe::save')}}</button>
            </form>
            <script>
                $(function() {
                    $('#board_manage_form').bind('submit', function() {
                        if ($('#list_selected').prop('disabled') == false) {
                            $('#list_selected option').each(function() {
                                var listColumn = $('<input>').attr('name', 'listColumns[]').val($(this).val()).attr('type', 'hidden');
                                $('#board_manage_form').append(listColumn);
                            });
                        }

                        if ($('#form_order').prop('disabled') == false) {
                            $('#form_order option').each(function() {
                                var listColumn = $('<input>').attr('name', 'formColumns[]').val($(this).val()).attr('type', 'hidden');
                                $('#board_manage_form').append(listColumn);
                            });
                        }
                    });
                });
            </script>
            </div>
        </div>
    </div>

    <!-- Skin config box -->
    <div class="panel">
        <div class="panel-heading">
            <div class="row">
                <p class="txt_tit">{{xe_trans('xe::skin')}}</p>

                <div class="right_btn pull-right" role="button" data-toggle="collapse" data-parent="#accordion" data-target="#skinSection">
                    <!-- [D] 메뉴 닫기 시 버튼 클래스에 card_close 추가 및 item_container none/block 처리-->
                    <button class="btn_clse ico_gray pull-left"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="blind">{{xe_trans('xe::menuClose')}}</span></button>
                </div>

            </div>
        </div>
        <div id="skinSection" class="panel-collapse collapse" role="tabpanel">
            <div class="panel-body panel-collapse collapse in">
                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        {!! $skinSection !!}
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- DynamicField config box -->
    <div class="panel">
        <div class="panel-heading">
            <div class="row">
                <p class="txt_tit">{{xe_trans('xe::dynamicField')}}</p>

                <div class="right_btn pull-right" role="button" data-toggle="collapse" data-parent="#accordion" data-target="#dynamicFieldSection">
                    <!-- [D] 메뉴 닫기 시 버튼 클래스에 card_close 추가 및 item_container none/block 처리-->
                    <button class="btn_clse ico_gray pull-left"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="blind">{{xe_trans('xe::menuClose')}}</span></button>
                </div>

            </div>
        </div>
        <div id="dynamicFieldSection" class="panel-collapse collapse" role="tabpanel">
            <div class="panel-body panel-collapse collapse in">
                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        {!! $dynamicFieldSection !!}
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- ToggleMenu config box -->
    <div class="panel">
        <div class="panel-heading">
            <div class="row">
                <p class="txt_tit">{{xe_trans('xe::toggleMenu')}}</p>

                <div class="right_btn pull-right" role="button" data-toggle="collapse" data-parent="#accordion" data-target="#toggleMenuSection">
                    <!-- [D] 메뉴 닫기 시 버튼 클래스에 card_close 추가 및 item_container none/block 처리-->
                    <button class="btn_clse ico_gray pull-left"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="blind">{{xe_trans('xe::menuClose')}}</span></button>
                </div>

            </div>
        </div>
        <div id="toggleMenuSection" class="panel-collapse collapse" role="tabpanel">
            <div class="panel-body panel-collapse collapse in">
                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        {!! $toggleMenuSection !!}
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Comment config box -->
    <div class="panel">
        <div class="panel-heading">
            <div class="row">
                <p class="txt_tit">{{xe_trans('xe::comment')}}</p>

                <div class="right_btn pull-right" role="button" data-toggle="collapse" data-parent="#accordion" data-target="#commentSection">
                    <!-- [D] 메뉴 닫기 시 버튼 클래스에 card_close 추가 및 item_container none/block 처리-->
                    <button class="btn_clse ico_gray pull-left"><i class="xi-angle-down"></i><i class="xi-angle-up"></i><span class="blind">{{xe_trans('xe::menuClose')}}</span></button>
                </div>

            </div>
        </div>
        <div id="commentSection" class="panel-collapse collapse" role="tabpanel">
            <div class="panel-body panel-collapse collapse in">
                @if($config->get('comment') == true)
                    {!! $commentSection !!}
                @else
                    {{xe_trans('xe::disUse')}}
                @endif
            </div>
        </div>
    </div>
</div>
</section>

