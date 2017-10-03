@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row col-lg-12">
        <div id="sidebar">  
            <form role="form" method="get" action="{{route('filterKadet')}}" >     
                <div class="form-group col-lg-12"  style="padding-bottom: 100%;">
                    <h3>Фильтры</h3><br><br>
                    <label for="fbirthdate">По дате рождения</label><br>
                    от <input type="date" name="fbirthdate" class="form-control">
                    до <input type="date" name="sbirthdate" class="form-control"><br>
                    <label for="class">По классу</label>
                    <select name="class[]" class="form-control select" multiple="multiple">
                        <option value=""></option>
                        @foreach($kadets['classes'] as $class)
                        <option value="{{$class->account}}">{{$class->nameClass}}</option>
                        @endforeach
                    </select>
                    <br><br>
                    <button type="submit" class="btn btn-success ">Применить</button>   
                    <a href="/kadet">
                        <button type="button" class="btn btn-info" >Сбросить фильтр</button>
                    </a>
                    <a href="#myModal2"  data-toggle="modal"><button type="button" style="margin-top: 4px" class="btn btn-info" >Экспорт кадетов</button></a>
                </div>
            </form>

        </div>
    <div class="main-content">
        <div class="swipe-area"></div>
        <a href="#" data-toggle=".container" id="sidebar-toggle" >
            <span>Фильтры</span>
        </a>
        <div class="row">
            <div class="content">
                <div class="panel-info" >
                    <div class="panel-heading"><h3 style="padding-left:5%;">Все кадеты</h3><br></div>
                </div>
                <br><br>  
                <div class="table-responsive">
                    <table class="table table-hover ">
                        <thead style="font-weight: bold;">
                            <tr>
                                <td>#</td>
                                <td>Фио кадета</td>
                                <td>Дата Рождения</td>
                                <td>Учится ли</td>
                                <td>Класс</td>
                                <td>Рота</td>
                                <td>Курс</td>
                                <td>Куратор</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kadets['kadets'] as $kadet)
                            <tr>
                                <td>{{$kadet->account}}</td>
                                <td>{{$kadet->KLastName}} {{$kadet->KFirstName}} {{$kadet->KSecondName}}</td>
                                <td>{{$kadet->birthdata}}</td>
                                <td>{{$kadet->studyKK}}</td>
                                <td>{{$kadet->nameclass}}</td>
                                <td>{{$kadet->nameRota}}</td>
                                <td>{{$kadet->nameCourse}}</td>
                                <td>{{$kadet->LastName}} {{$kadet->FirstName}} {{$kadet->SecondName}}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    @if($status==0)
                        <p>По вашему запросу ничего не найдено</p>
                    @endif
                </div>
            </div>
        </div>
    </div>     
<div>  
    {{$kadets['kadets']->links()}}
</div>

</div>
</div>   

<div id="myModal2" class="modal fade">
        <form method="post" id="upload" action="/export/kadets">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Заголовок модального окна -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Выберете класс</h4>
                    </div>
                    <!-- Основное содержимое модального окна -->
                    <div class="modal-body">
                        <select name="class" class="form-control select" style="width:100%">
                        <option value=""></option>
                        @foreach($kadets['classes'] as $class)
                        <option value="{{$class->account}}">{{$class->nameClass}}</option>
                        @endforeach
                    </select>
                    </div>
                    <!-- Футер модального окна -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary">Экспорт</label>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

