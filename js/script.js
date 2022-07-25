
function deleteProject(project_id)
{

    fetch("../delete.php", {
        method: "POST",
        body: JSON.stringify({project_id : project_id}),
        headers: {
            "Content-Type": "application/json"
        }
    })
    .then(response => {
        console.log(response);
        document.querySelector("#project-"+project_id).remove();
    })
    .catch(function (err) {
        console.log("Failed to fetch page: ", err);
    });
}
