@extends('layouts.app')

@section('content')
<div class="container ">
    <div class="row col-md-11" style="left: 5%;">   
        <div class="panel-warning" >
            <div class="panel-heading"><h3 style="padding-left:5%;">+Добавить мероприятие</h3><br>
            </div>
        </div>
        <br><br>

        @if($status !== NULL)
        <p style="color:green;">{{$status}}</p>
        @endif
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form role="form" method="post" enctype="multipart/form-data" action="{{route('savePart')}}">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="kadet">Кадет</label>
                <select class="form-control select" name="kadet">
                    <option value=""></option>
                    @foreach($data['kadets'] as $kadet)
                    <option value="{{$kadet->account}}">{{$kadet->KLastName}} {{$kadet->KFirstName}} {{$kadet->KSecondName}}</option>
                    @endforeach
                </select>
                <div class="form-group form-element-date" style="width: 20%;">
                        <label for="dataEvent">
                            Дата проведения
                        </label>
                        <div class="input-date input-group">
                            <input class="form-control" name="data" type="date" >
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>

                    </div>
                </div> 
                <label for="event">Мероприятие</label>
                <select name="event" class='form-control select'>
                    <option value=""></option>
                    @foreach($data['Events'] as $event)
                    <option value="{{$event->account}}">{{$event->nameEvent}}</option>
                    @endforeach
                </select>


                <label for="class">Класс</label>
                <select class="form-control select" name="class">
                    <option value=""></option>
                    @foreach($data['class'] as $class)
                    <option value="{{$class->nameClass}}"> {{$class->nameClass}} </option>
                    @endforeach
                </select>
                <label for="teacher">Преподаватель</label>
                <select class="form-control select" name="teacher[]" multiple>
                    <option value=""></option>
                    @foreach($data['teachers'] as $teacher)
                    <option value="{{$teacher->id}}">{{$teacher->LastName}} {{$teacher->FirstName}} {{$teacher->SecondName}}</option>
                    @endforeach
                </select>

                <label for="reach">Место</label>
                <select class="form-control select" name="reach">
                    <option value=""></option>
                    @foreach($data['reach'] as $reach)
                    <option value="{{$reach->account}}">{{$reach->nameReach}}</option>
                    @endforeach
                </select>

                <label for="subject">Предмет</label>
                <select class="form-control select" name="subject">
                    <option value=""></option>
                    @foreach($data['subject'] as $subject)
                    <option value="{{$subject->account}}">{{$subject->nameSubject}}</option>
                    @endforeach
                </select>
                <br><br>
                <input type="file" accept="image/*" name="image">
                <br><br>

                <button type="submit" class="btn btn-success ">Добавить</button>   
            </div>
        </form>
    </div>
</div>

@endsection