const prescriptions = [
    {
        date: "07/10/2023",
        patient: "John Doe",
        Medical_resume: "Bacterial Infection",
        status: "Active"
    },
    {
        date: "12/09/2023",
        patient: "Jane Doe",
        Medical_resume: "Viral Infection",
        status: "Complete"
    }
];

function loadPrescription(){
    const prescriptionList = document.querySelector(".prescription_data");
    prescriptionList.innerHTML="";
    prescriptions.forEach(item=>{
        const row=`<tr>
        <td>${item.date}</td>
        <td>${item.patient}</td>
        <td>${item.Medical_resume}</td>
        <td>${item.status}</td>
        <td class="text-end">
            <button class="btn btn-sm btn-secondary">Send PDF</button>
        </td>
        </tr>`;
        prescriptionList.innerHTML+=row;
    })

}
document.addEventListener("DOMContentLoaded",loadPrescription);