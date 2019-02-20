@extends('layouts.master')

@section('title', 'Quotations/Upload')

@section('page_heading', 'Quotations')

@section('content')
    <section class="section--center mdl-grid mdl-grid--no-spacing mdl-shadow--2dp">
        <div class="mdl-card mdl-cell mdl-cell--12-col">
            <div class="mdl-card__supporting-text mdl-grid mdl-grid--no-spacing">

                <form id="form1" method="POST" action="{{ route('quotations') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="mdl-textfield mdl-js-textfield">
                        <input class="mdl-textfield__input" type="text" id="quoteLabel" name="quoteLabel">
                        <label class="mdl-textfield__label" for="quoteLabel">Label</label>
                    </div>

                    <div>
                        <input type="file" name="uploadedFile" />
                    </div>

                    <!--<div style="height: 50px">
                        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect">
                            Attach PDF
                        </button>
                        <input type="file" name="fileupload" />
                    </div>-->
                </form>
            </div>

            <div class="mdl-card__actions">
                <a href="#" class="mdl-button" onclick="document.getElementById('form1').submit();">
                    Submit
                </a>
            </div>

        </div>
    </section>

    <style>
        .mdl-demo .mdl-layout.is-small-screen .mdl-layout__header-row h3 {
            font-size: inherit;
        }
        .mdl-demo .mdl-layout__tab-bar-button {
            display: none;
        }
        .mdl-demo .mdl-layout.is-small-screen .mdl-layout__tab-bar .mdl-button {
            display: none;
        }
        .mdl-demo .mdl-layout:not(.is-small-screen) .mdl-layout__tab-bar,
        .mdl-demo .mdl-layout:not(.is-small-screen) .mdl-layout__tab-bar-container {
            overflow: visible;
        }
        .mdl-demo .mdl-layout__tab-bar-container {
            height: 64px;
        }
        .mdl-demo .mdl-layout__tab-bar {
            padding: 0;
            padding-left: 16px;
            box-sizing: border-box;
            height: 100%;
            width: 100%;
        }
        .mdl-demo .mdl-layout__tab-bar .mdl-layout__tab {
            height: 64px;
            line-height: 64px;
        }
        .mdl-demo .mdl-layout__tab-bar .mdl-layout__tab.is-active::after {
            background-color: white;
            height: 4px;
        }
        .mdl-demo main > .mdl-layout__tab-panel {
            padding: 8px;
            padding-top: 48px;
        }
        .mdl-demo .mdl-card {
            height: auto;
            display: flex;
            flex-direction: column;
        }
        .mdl-demo .mdl-card > * {
            height: auto;
        }
        .mdl-demo .mdl-card .mdl-card__supporting-text {
            margin: 40px;
            flex-grow: 1;
            padding: 0;
            color: inherit;
            width: calc(100% - 80px);
        }
        .mdl-demo.mdl-demo .mdl-card__supporting-text h4 {
            margin-top: 0;
            margin-bottom: 20px;
        }
        .mdl-demo .mdl-card__actions {
            margin: 0;
            padding: 4px 40px;
            color: inherit;
        }
        .mdl-demo .mdl-card__actions a {
            color: #617E8A;
            margin: 0;
        }
        .mdl-demo .mdl-card__actions a:hover,
        .mdl-demo .mdl-card__actions a:active {
            color: inherit;
            background-color: transparent;
        }
        .mdl-demo .mdl-card__supporting-text + .mdl-card__actions {
            border-top: 1px solid rgba(0, 0, 0, 0.12);
        }
        .mdl-demo #add {
            position: absolute;
            right: 40px;
            top: 36px;
            z-index: 999;
        }

        .mdl-demo .mdl-layout__content section:not(:last-of-type) {
            position: relative;
            margin-bottom: 48px;
        }
        .mdl-demo section.section--center {
            max-width: 860px;
        }
        .mdl-demo #features section.section--center {
            max-width: 620px;
        }
        .mdl-demo section > header{
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .mdl-demo section > .section__play-btn {
            min-height: 200px;
        }
        .mdl-demo section > header > .material-icons {
            font-size: 3rem;
        }
        .mdl-demo section > button {
            position: absolute;
            z-index: 99;
            top: 8px;
            right: 8px;
        }
        .mdl-demo section .section__circle {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            flex-grow: 0;
            flex-shrink: 1;
        }
        .mdl-demo section .section__text {
            flex-grow: 1;
            flex-shrink: 0;
            padding-top: 8px;
        }
        .mdl-demo section .section__text h5 {
            font-size: inherit;
            margin: 0;
            margin-bottom: 0.5em;
        }
        .mdl-demo section .section__text a {
            text-decoration: none;
        }
        .mdl-demo section .section__circle-container > .section__circle-container__circle {
            width: 64px;
            height: 64px;
            border-radius: 32px;
            margin: 8px 0;
        }
        .mdl-demo section.section--footer .section__circle--big {
            width: 100px;
            height: 100px;
            border-radius: 50px;
            margin: 8px 32px;
        }
        .mdl-demo .is-small-screen section.section--footer .section__circle--big {
            width: 50px;
            height: 50px;
            border-radius: 25px;
            margin: 8px 16px;
        }
        .mdl-demo section.section--footer {
            padding: 64px 0;
            margin: 0 -8px -8px -8px;
        }
        .mdl-demo section.section--center .section__text:not(:last-child) {
            border-bottom: 1px solid rgba(0,0,0,.13);
        }
        .mdl-demo .mdl-card .mdl-card__supporting-text > h3:first-child {
            margin-bottom: 24px;
        }
        .mdl-demo .mdl-layout__tab-panel:not(#overview) {
            background-color: white;
        }
        .mdl-demo #features section {
            margin-bottom: 72px;
        }
        .mdl-demo #features h4, #features h5 {
            margin-bottom: 16px;
        }
        .mdl-demo .toc {
            border-left: 4px solid #C1EEF4;
            margin: 24px;
            padding: 0;
            padding-left: 8px;
            display: flex;
            flex-direction: column;
        }
        .mdl-demo .toc h4 {
            font-size: 0.9rem;
            margin-top: 0;
        }
        .mdl-demo .toc a {
            color: #4DD0E1;
            text-decoration: none;
            font-size: 16px;
            line-height: 28px;
            display: block;
        }
    </style>
@endsection