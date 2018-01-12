@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row col-lg-12">
        <div id="sidebar">  
        <form role="form" method="get" action="{{route('filterClass')}}">     
            <div class="form-group col-lg-12" style="padding-bottom: 100%;">
                <h3>Фильтры</h3><br><br>
                <label for="class">По классу</label>
                <select name="class[]" multiple="multiple" class="select form-control ">
                    <option value=""></option>
                        @foreach($classes['class'] as $class)
                            <option value="{{$class->account}}">{{$class->nameClass}}</option>
                        @endforeach
                </select><br><br>
                <label for="rota">По роте</label>
                <select name="rota[]" multiple="multiple" class="form-control select">
                    <option value=""></option>
                        @foreach($classes['rotas'] as $rota)
                            <option value="{{$rota->account}}">{{$rota->nameRota}}</option>
                        @endforeach
                </select><br><br>
                <label for="course">По курсу</label>
                <select name="course[]" multiple="multiple" class="select form-control ">
                    <option value=""></option>
                        @foreach($classes['courses'] as $course)
                            <option value="{{$course->nameCourse}}">{{$course->nameCourse}}</option>
                        @endforeach
                </select><br><br>
                <label for="employee">По воспитателю</label>
                <select name="employee" class="select form-control ">
                    <option value=""></option>
                        @foreach($classes['employees'] as $teacher)
                            <option value="{{$teacher->id}}">{{$teacher->LastName}} {{$teacher->FirstName}} {{$teacher->SecondName}}</option>
                        @endforeach
                </select>
                <br><br>
                <button type="submit" class="btn btn-success ">Применить</button>   
                <a href="/class">
                <button type="button" class="btn btn-info" >Сбросить фильтр</button>
                </a>
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
            <div class="panel-info">
            <div class="panel-heading"><h3 style="padding-left:5%;">Все классы</h3><br>
                </div>
            </div>
                <br><br>  
        <div class="table-responsive">
        <table class="table table-hover ">
                        <thead style="font-weight: bold;">
                            <tr>
                            <td>#</td>
                            <td>Имя класса</td>
                            <td>Количество кадетов</td>
                            <td>Рота</td>
                            <td>Курс</td>
                            <td>Воспитатель</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classes['classes'] as $class)
                            <tr>

                                <td>{{$class->account}}</td>
                                <td>{{$class->nameClass}}</td>
                                <td>{{$class->quantity}}</td>
                                <td>{{$class->nameRota}}</td>
                                <td>{{$class->nameCourse}}</td>
                                <td>{{$class->LastName}} {{$class->FirstName}} {{$class->SecondName}}</td>
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
    {{$classes['classes']->links()}}
</div>
</div>
</div>  
@endsection

