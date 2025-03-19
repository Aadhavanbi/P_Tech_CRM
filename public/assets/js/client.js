function deleteClient(clientId) {
    if (confirm("Are you sure you want to delete this client? This action cannot be undone.")) {
        fetch(`client_delete/${clientId}`, {
            method: "DELETE",
            headers: { "X-Requested-With": "XMLHttpRequest" }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert("Client deleted successfully!");
                location.reload();
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => console.error("Error:", error));
    }
}
