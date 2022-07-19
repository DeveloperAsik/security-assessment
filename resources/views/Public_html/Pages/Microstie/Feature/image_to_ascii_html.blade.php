<style>
    html {
        height: 100%;
    }

    body {
        height: 100%;
        background-image: linear-gradient(#8a2be3, #0000ff);
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    * {
        margin: 0;
    }

    body {
        padding: 2rem 3rem;
        font-family: 'VT323', monospace;
        line-height: 1.5rem;
        font-size: 18px;
    }

    header {
        display: flex;
        align-items: baseline;
        font-size: 18px;
    }

    header h1 {
        margin-right: 1.5rem;
    }

    input {
        margin-top: 2rem;
        font-size: 18px;
    }

    pre {
        font-family: 'Courier New', 'monospace';
        margin: 1rem auto;
        /*font-size: 8px;*/
        line-height: 1;
    }

    footer {
        position: absolute;
        bottom: 1rem;
    }

</style>
<div class="feature">
    <div class="header">
        <h1>Ascii Art Converter</h1>
        <p>Upload a picture and turn it into pure ASCII masterpiece!</p>
    </div>
    <div class="grid">
        <input type="file" name="picture" />
        <canvas id="preview" style="display: none;"></canvas>
        <pre id="ascii"></pre>
    </div>
    <div class="footer">
    </div>
</div>