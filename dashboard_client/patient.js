const prescriptions = [
    {
        date: "07/10/2023",
        type: "Rx",
        doctor: "Dr. Smith",
        status: "Active"
    },
    {
        date: "12/09/2023",
        type: "Plan",
        doctor: "Dr. Wilson",
        status: "Complete"
    }
];

function loadPrescription(){
    const prescriptionList = document.querySelector(".prescription_data");
    prescriptionList.innerHTML="";
    prescriptions.forEach(item=>{
        const row=`<tr>
        <td>${item.date}</td>
        <td>${item.type}</td>
        <td>${item.doctor}</td>
        <td>${item.status}</td>
        <td class="text-end">
            <button class="btn btn-sm btn-primary">View Details</button>
            <button class="btn btn-sm btn-secondary">Download PDF</button>
        </td>
        </tr>`;
        prescriptionList.innerHTML+=row;
    })

}
document.addEventListener("DOMContentLoaded",loadPrescription);