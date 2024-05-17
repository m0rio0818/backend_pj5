const deleteBtn = document.getElementById("delete");

const deleteInput = document.getElementById("delete_input");


deleteBtn.addEventListener("click", () => {
    const deleteID = deleteInput.value;
    const jsonform = { id: deleteID };


    if (deleteID != "") {
        fetch('/part/id', {
            method: "POST",
            body: JSON.stringify(jsonform)
        }).then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.status == "find") {
                    const finalCheck = window.confirm("本当に" + deleteID + "を削除してもよろしいでしょうか？")
                    if (finalCheck) {
                        fetch('/delete/part/id', {
                            method: "POST",
                            body: JSON.stringify(jsonform)
                        })
                            .then(response => response.json())
                            .then(data => {
                                window.alert(deleteID + data["message"])
                            })
                    }
                    deleteInput.value = "";
                } else if (data.status == "not found") {
                    window.alert("一致するIDは見つかりません.確認し、検索してください")
                    deleteInput.value = "";
                }
            })
        // .catch((error) => {
        //     // ネットワークエラーかJSONの解析エラー
        //     console.error('Error:', error);
        //     alert('An error occurred. Please try again.');
        // });

    } else {
        window.alert("idを入力してください");
    }

})
