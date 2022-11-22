<!DOCTYPE html>
<html>
<head>
    <title>Processing video</title>
    <style>
        body {
            background-color: #333;
            color: #fff;
            overflow: hidden;
        }
        h1 {
            font-family: 'Courier New', Courier, monospace;
            text-align: center;
            font-size: 3em;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        img {
            width: 50%;
        }
        .add-button {
            border: 2px solid #4CAF50;
            background-color: transparent;
            color: #4CAF50;
            padding: 14px 28px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 8px;
        }
        .add-button:hover {
            background-color: #4CAF50;
            color: white;
        }
        .add-button:active {
            background-color: #3e8e41;
            border-color: #3e8e41;
            color: white;
        }
        form {
            margin-top: 30px;
        }
        select {
            background-color: #333;
            color: #fff;
            border-radius: 8px;
            padding: 14px 28px;
            font-size: 16px;
            cursor: pointer;
        }
        .blur {
            -webkit-filter: blur(5px);
            filter: blur(5px);
        }
        .rotate {
            -webkit-transform: rotate(180deg);
            transform: rotate(180deg);
        }
        .grayscale {
            -webkit-filter: grayscale(100%);
            filter: grayscale(100%);
        }
        .invert {
            -webkit-filter: invert(100%);
            filter: invert(100%);
        }
        .sepia {
            -webkit-filter: sepia(100%);
            filter: sepia(100%);
        }
        #list {
            position: absolute;
            top: 0;
            left: 0;
            padding: 0;
            margin: 0;
            margin-top: 20px;
            margin-left: 20px;
            padding: 10px;
            border: 1px solid #fff;
            border-radius: 8px;
            list-style: none;
        }
        .remove-button {
            border: 2px solid #f44336;
            background-color: transparent;
            color: #f44336;
            font-size: 12px;
            cursor: pointer;
            border-radius: 8px;
            margin-left: 10px;
        }
        .remove-button:hover {
            background-color: #f44336;
            color: white;
        }
        .remove-button:active {
            background-color: #d32f2f;
            border-color: #d32f2f;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Select what to do with the image:</h1>
        <img src="https://picsum.photos/1920/1080" alt="Image">
        <ul id="list" style="display: none;">
        </ul>
        <form action="index.php" method="post">
            <select name="action">
                <option value="blur">Blur</option>
                <option value="rotate">Rotate</option>
                <option value="grayscale">Grayscale</option>
                <option value="invert">Invert</option>
                <option value="sepia">Sepia</option>
            </select>
            <button type="button" class="add-button" name="action">Add</button>
        </form>
    </div>
</body>
<script>
    const select = document.querySelector('select');
    const list = document.querySelector('#list');
    const img = document.querySelector('img');

    document.querySelector('.add-button').addEventListener('click', function() {
        const li = document.createElement('li');
        const button = document.createElement('button');
        const value = select.options[select.selectedIndex].value;
        button.type = 'button';
        button.className = 'remove-button';
        button.innerHTML = '&times';
        button.addEventListener('click', function() {
            removeFilter(value, li);
        });
        li.innerHTML = value.charAt(0).toUpperCase() + value.slice(1);

        li.appendChild(button);

        list.appendChild(li);
        list.style.display = 'block';

        select.options[select.selectedIndex].remove();
        img.classList.add(value);
    });

    function removeFilter(filter, li) {
        img.classList.remove(filter);

        const option = document.createElement('option');
        option.value = filter;
        option.text = filter.charAt(0).toUpperCase() + filter.slice(1);
        select.add(option);

        li.remove();

        if (list.children.length === 0) {
            list.style.display = 'none';
        }
    }
</script>
</html>