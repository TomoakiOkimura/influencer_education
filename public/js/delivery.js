document.addEventListener('DOMContentLoaded', function() {
    
    // 削除ボタンの処理
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const id = row.dataset.id;

            if (id) {
                fetch(`/delivery/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        row.remove();
                    } else {
                        alert('削除に失敗しました');
                    }
                });
            } else {
                row.remove();
            }
        });
    });

    // 行追加ボタンの処理
    document.getElementById('add-row').addEventListener('click', function() {
        const tbody = document.getElementById('delivery_times');
        const newRow = tbody.insertRow();
        newRow.innerHTML = `
            <tr>
                <td><input type="text" name="delivery_from_date[]" placeholder="年月日"></td>
                <td><input type="text" name="delivery_from_time[]" placeholder="時分"></td>
                <td><h3>～</h3></td>
                <td><input type="text" name="delivery_to_date[]" placeholder="年月日"></td>
                <td><input type="text" name="delivery_to_time[]" placeholder="時分"></td>
                <td><button type="button" class="delete-btn">×</button></td>
            </tr>
        `;
        newRow.querySelector('.delete-btn').addEventListener('click', function() {
            newRow.remove();
        });
    });
});