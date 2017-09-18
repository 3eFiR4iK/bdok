@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row col-lg-12">
        <div id="sidebar">   
        <form role="form" method="get" action="{{route('filterPart')}}">
            <div class="form-group col-lg-12" >
                <h3>Фильтры</h3><br><br>
                <label for="event">По мероприятию</label>
                <select name="event[]" multiple="multiple" class='select form-control'>
                    <option value=""></option>
                    @foreach($posts['Events'] as $event)
                    <option value="{{$event->nameEvent}}">{{$event->nameEvent}}</option>
                    @endforeach
                </select><br><br>
                <label for="firstData">По дате</label><br>
                от<input type="date" name="firstData" class="form-control">
                до<input type="date" name="secondData" class="form-control"><br>
                <label for="class">По классу</label>
                <select class="form-control select" name="class[]" multiple="multiple">
                    <option value=""></option>
                    @foreach($posts['class'] as $class)
                    <option value="{{$class->nameClass}}"> {{$class->nameClass}} </option>
                    @endforeach
                </select><br>
                <label for="teacher">По преподавателю</label>
                <select class="form-control  select" name="teacher">
                    <option value=""></option>
                    @foreach($posts['teachers'] as $teacher)
                    <option value="{{$teacher->id}}">{{$teacher->LastName}} {{$teacher->FirstName}} {{$teacher->SecondName}}</option>
                    @endforeach
                </select>
                <br>
                <label for="kadet">По кадету</label>
                <select class="form-control  select"  name="kadet">
                    <option value=""></option>
                    @foreach($posts['kadets'] as $kadet)
                    <option value="{{$kadet->account}}">{{$kadet->KLastName}} {{$kadet->KFirstName}} {{$kadet->KSecondName}}</option>
                    @endforeach
                </select><br><br>

                <button type="submit" class="btn btn-success ">Применить</button>   
                <a href="/part">
                    <button type="button" class="btn btn-info" >Сбросить фильтр</button>
                </a>

            </div></form>
    </div>
    <div class="main-content">
        <div class="swipe-area"></div>
        <a href="#" data-toggle=".container" id="sidebar-toggle" >
            <span>Фильтры</span>
        </a>

        <div class="row">
            <div class="content">   
                <div class="panel-info" >
                    <div class="panel-heading"><h3 style="padding-left:5%; ">Все мероприятия</h3><br></div>
                </div>
                <br><br>    
                <div class="table-responsive">
                    <table class="table table-hover ">
                        <thead style="font-weight: bold;">
                            <tr>
                                <td>#</td>
                                <td>Фио кадета</td>
                                <td>Место</td>
                                <td>Мероприятие</td>
                                <td>Дата проведения</td>
                                <td>Фио Преподавателя</td>
                                <td>Предмет</td>
                                <td>Класс</td>
                                <td>Грамота</td>
                            </tr>
                        <thead>
                        <tbody>
                            @foreach($posts['posts'] as $post)
                            <tr>
                                <td>{{$post->part_id}}</td>
                                <td>{{$post->KLastName}} {{$post->KFirstName}} {{$post->KSecondName}}</td>
                                <td>{{$post->nameReach}}</td>
                                <td>{{$post->nameEvent}}</td>
                                <td>{{$post->dataEvent}}</td>
                                <td>{{$post->full_name}}</td>
                                <td>{{$post->nameSubject}}</td>
                                <td>{{$post->nClass}} (-<?php $create = explode('-', $post->creat);
                                        echo substr($create[0],2).'г.'; ?>)<td>
                                @if($post->diploma!==NULL)
                                <td><a href='{{$post->diploma}}' data-rel="lightcase"> Просмотреть </a></td>
                                @else
                                <td>&nbsp;</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                     <a href="/part/toexcel">
                    <button type="button" class="btn btn-success" >Экспорт в Excel</button>
                    </a>
                    @if($status==0)
                        <p>По вашему запросу ничего не найдено</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
        
<div>  
    {{ $posts['posts']->links() }}
</div>

</div>
</div>


@endsection
