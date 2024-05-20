<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Post App</title>
    <style>
        #posts {
            max-width: 500px;
            margin: 20px auto;
        }

        .post {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px 0;
        }
    </style>
</head>

<body>

    <div id="posts"></div>

    <div style="text-align: center;">
        <textarea id="postInput" rows="4" cols="50" placeholder="Write your post here..."></textarea><br><br>
        <button onclick="addPost()">Add Post</button>
        <button onclick="clearStorage()">Clear Storage</button>
    </div>

    <script>
        // localStorageに投稿があるかチェックし、表示します
        window.onload = function() {
            displayPosts();
        }

        function addPost() {
            const postInput = document.getElementById('postInput');
            const postText = postInput.value.trim();

            if (postText) {
                // localStorageから投稿を取得するか、存在しない場合は空の配列を初期化します
                const posts = JSON.parse(localStorage.getItem('posts')) || [];

                // 配列に新しい投稿を追加します
                posts.push(postText);

                // 更新された投稿の配列をlocalStorageに保存します
                localStorage.setItem('posts', JSON.stringify(posts));

                // 入力フィールドをクリアします
                postInput.value = '';

                // 投稿を表示します
                displayPosts();
            } else {
                alert('Please write something in the post!');
            }
        }

        function displayPosts() {
            const postsDiv = document.getElementById('posts');
            const posts = JSON.parse(localStorage.getItem('posts')) || [];
            let html = '';

            posts.forEach(post => {
                html += `<div class="post">${post}</div>`;
            });

            postsDiv.innerHTML = html;
        }

        function clearStorage() {
            // localStorageの投稿を消去します
            localStorage.removeItem('posts');

            // 表示されている投稿を消去します
            document.getElementById('posts').innerHTML = '';
        }
    </script>

</body>

</html>