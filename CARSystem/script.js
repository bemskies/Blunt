document.getElementById('reportForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    try {
        const response = await fetch('submit_report.php', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();

        if (data.success) {
            document.getElementById('response').innerHTML = `
                <div style="background: #d4edda; color: #155724; padding: 10px;">
                    Report submitted successfully! Case ID: ${data.case_id}
                </div>
            `;
            form.reset();
        }
    } catch (error) {
        console.error('Error:', error);
    }
});