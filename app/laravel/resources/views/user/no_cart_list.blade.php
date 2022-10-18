@extends('layouts.layout')

@section('content')

    <main>

        <div class="container">
            <div class="row">
                <div class="col-12 card border-dark mt-5">
                    <div class="cord-body ml-3 mb-2">
                        <h4 class="mt-4">お届け先</h4>
                        <p class="mb-2" style="padding-left: 20px;">
                            
                        </p>
                        <p style="padding-left: 160px;">
                            
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <table class="table mt-5 ml-3 border-dark">
                    
                    <tr class="text-center">
                        <h3>カートに商品がありません</h3>
                    </tr>
                        <tr class="text-right">
                            <th class="border-0"></th>
                            <td class="border-0">
                                <a class="btn btn-success" href="{{ url('/') }}" role="button">
                                    TOPに戻る
                                </a>
                            </td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

@endsection