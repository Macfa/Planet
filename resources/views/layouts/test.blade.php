<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CKEditor 5 Framework – Quick start</title>

    <style>
        .simple-box {
            padding: 10px;
            margin: 1em 0;

            background: rgba( 0, 0, 0, 0.1 );
            border: solid 1px hsl(0, 0%, 77%);
            border-radius: 2px;
        }

        .simple-box-title, .simple-box-description {
            padding: 10px;
            margin: 0;

            background: #FFF;
            border: solid 1px hsl(0, 0%, 77%);
        }

        .simple-box-title {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div id="editor">
    <p>Simple video:</p>
    <figure class="video">
        <video src="https://file-examples-com.github.io/uploads/2017/04/file_example_MP4_480_1_5MG.mp4"></video>
    </figure>

    <section class="simple-box">
        <h1 class="simple-box-title">Box title</h1>
        <div class="simple-box-description">
            <p>The description goes here.</p>
            <ul>
                <li>It can contain lists,</li>
                <li>and other block elements like headings.</li>
            </ul>
        </div>
    </section>
</div>

<script src="test/bundle.js"></script>
</body>
</html>
