<!DOCTYPE html>

@extends('layouts.main')

@section('title', 'New ad')

@section('add_button')
@endsection

@section('content')

    @if (count($errors) > 0)
        <div class="alerts">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<form action="<?= url('new_ad'); ?>" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Title:</td>
                <td><input type="text" name="title"></td>
            </tr>
            <tr>
                <td>Text:</td>
                <td><textarea name="text"></textarea></td>
            </tr>
            <tr>
                <td>Image:</td>
                <td><input type="file" name="image"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="submit" value="Add"></td>
            </tr>
        </table>
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
    </form>
@endsection