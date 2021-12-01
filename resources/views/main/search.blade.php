{{--@extends('layouts.master')--}}
@extends('layouts.main')
@extends( ($searchType==="ch") ? 'layouts.main-sub' : 'layouts.main-index')
@extends('layouts.content-search')
@extends('layouts.sidebar')
