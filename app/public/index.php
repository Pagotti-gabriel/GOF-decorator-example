<!DOCTYPE html>
<html>
<head>
    <title>Processing images</title>
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
        .list-container {
            width: 10%;
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
        }
        #list {
            list-style: none;
            padding: 0;
        }
        #list > li {
            padding: 3px;
            display: flex;
            justify-content: space-between;
        }
        #list > li:hover {
            background-color: #555;
            border-radius: 8px;
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
        .title {
            margin: 0;
            padding: 0;
            font-size: 18px;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Select what to do with the image:</h1>
        <img src="https://picsum.photos/1920/1080" alt="Image">
        <div class="list-container">
            <p class="title">Filters:</p>
            <ul id="list"></ul>
        </div>
        <form action="index.php" method="post">
            <select name="action"></select>
            <button type="button" class="add-button" name="action">Add</button>
            <button type="button" class="add-button" name="process" onclick="processFilters()">Process</button>
        </form>
    </div>
</body>
<script>
    let selectedFilters = [];
    let nonSelectedFilters = [];

    function updateList() {
        const list = document.querySelector('#list');

        list.innerHTML = '';
        selectedFilters.forEach(filter => {
            const li = document.createElement('li');
            li.innerHTML = filter.charAt(0).toUpperCase() + filter.slice(1);
            const button = document.createElement('button');
            button.classList.add('remove-button');
            button.innerHTML = '&times';
            button.addEventListener('click', () => {
                removeFilter(filter, li);
            });

            li.appendChild(button);
            list.appendChild(li);
        });
    }

    function updateSelect() {
        select = document.querySelector('select');
        select.innerHTML = '';
        nonSelectedFilters.forEach(filter => {
            option = document.createElement('option');
            option.value = filter;
            option.innerHTML = filter.charAt(0).toUpperCase() + filter.slice(1);
            select.appendChild(option);
        });
    }

    document.querySelector('.add-button').addEventListener('click', function() {
        select = document.querySelector('select');
        value = select.value;
        if (value && !selectedFilters.includes(value)) {
            selectedFilters.push(value);
            updateList();
        }

        select.options[select.selectedIndex].remove();
    });

    function removeFilter(filter, li) {
        index = selectedFilters.indexOf(filter);
        selectedFilters.splice(index, 1);

        nonSelectedFilters.push(filter);
        updateList();
        updateSelect();
    }

    function processFilters() {
        const xhr = new XMLHttpRequest();

        params = getParamsToURL();
        xhr.open('GET', 'http://127.0.0.1/process.php?'+params);
        xhr.onload = function() {
            if (xhr.status !== 200) {
                return;
            }

            const response = JSON.parse(xhr.responseText);

            selectedFilters = response.selectedFilters;
            updateList();

            nonSelectedFilters = response.nonSelectedFilters;
            updateSelect();

            document.querySelector('img').style = response.style;
        };

        xhr.send(JSON.stringify(selectedFilters));
    }

    function getParamsToURL() {
        let params = '';
        selectedFilters.forEach(filter => {
            params += `&filters[]=${filter}`;
        });

        return params;
    }

    processFilters();
</script>
</html>