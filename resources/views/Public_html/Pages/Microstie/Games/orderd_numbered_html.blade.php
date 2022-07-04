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

    .game {
        /* position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%); */
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.5);
        padding: 15px;
        background-color: #ff1493;
        border-radius: 5px;
    }

    .grid {
        display: grid;
        grid-template-columns: 80px 80px 80px 80px;
        grid-template-rows: 80px 80px 80px 80px;
        border: 1px solid #550000;
    }

    .grid button {
        background-color: #cfcfcf;
        color: #003333;
        font-size: 24px;
        font-weight: bold;
        border: 1px solid #550000;
        outline: none;
        cursor: pointer;
    }

    .footer {
        margin-top: 15px;
        display: flex;
        justify-content: space-between;
    }

    .footer button {
        border: none;
        font-size: 20px;
        font-weight: bold;
        border-radius: 5px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.5);
        padding: 5px;
        width: 80px;
        background-color: #D4EE9F;
        color: #003333;
        outline: none;
        cursor: pointer;
    }

    .footer button:hover {
        color: #D4EE9F;
        background-color: #003333;
    }

    .footer span {
        flex: 1;
        text-align: center;
        font-size: 20px;
        color: #D4EE9F;
        font-weight: bold;
        margin: auto 0;
    }

    .message {
        color:#AA3939;
        height: 80px;
    }
</style>
<div class="game">
    <div class="grid">
        <button>1</button>
        <button>2</button>
        <button>3</button>
        <button>4</button>
        <button>5</button>
        <button>6</button>
        <button>7</button>
        <button>8</button>
        <button>9</button>
        <button>10</button>
        <button>11</button>
        <button>12</button>
        <button>13</button>
        <button>14</button>
        <button>15</button>
        <button></button>
    </div>
    <div class="footer">
        <button>Play</button>
        <span id="move">Move: 100</span>
        <span id="time">Time: 100</span>
    </div>
</div>
<h1 class="message">You win!</h1>