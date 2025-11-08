async function viewReport(e) {
    const caseId = e.currentTarget.getAttribute('data-id');
    
    try {
        const response = await fetch(`get_report_details.php?case_id=${caseId}`);
        const data = await response.json();
        
        if (data.error) throw new Error(data.error);

        const { report, media } = data;
        
        let mediaHTML = '';
        if (media.length > 0) {
            mediaHTML = `
                <div class="detail-group">
                    <h3>Media Evidence (${media.length})</h3>
                    <div class="media-gallery">
                        ${media.map(item => `
                            <div class="media-item">
                                ${item.file_type === 'image' ? 
                                    `<img src="${item.view_url}" alt="Evidence">` :
                                    item.file_type === 'video' ?
                                    `<video controls><source src="${item.view_url}" type="video/mp4"></video>` :
                                    `<audio controls><source src="${item.view_url}" type="audio/mpeg"></audio>`
                                }
                                <p>${item.file_name}</p>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        }

        modalBody.innerHTML = `
            <div class="detail-group">
                <h3>Case ID: ${report.case_id}</h3>
                <p><strong>Reported on:</strong> ${new Date(report.created_at).toLocaleString()}</p>
                <p><strong>Status:</strong> <span class="status-badge ${report.status.toLowerCase().replace(' ', '-')}">${report.status}</span></p>
            </div>
            
            <div class="detail-group">
                <h3>Child Information</h3>
                <p><strong>Name:</strong> ${report.child_name}</p>
                <p><strong>Age:</strong> ${report.age}</p>
                <p><strong>Gender:</strong> ${report.gender}</p>
            </div>
            
            <div class="detail-group">
                <h3>Incident Details</h3>
                <p><strong>Date:</strong> ${new Date(report.incident_date).toLocaleDateString()}</p>
                <p><strong>Location:</strong> ${report.location}</p>
                <p><strong>Description:</strong></p>
                <div class="description-box">${report.description}</div>
            </div>
            
            <div class="detail-group">
                <h3>Reporter Information</h3>
                <p><strong>Name:</strong> ${report.reporter_name}</p>
                <p><strong>Contact:</strong> ${report.reporter_contact}</p>
            </div>
            
            ${mediaHTML}
            
            <div class="action-buttons">
                <button class="status-btn" data-status="Under Review" data-id="${report.case_id}">Mark Under Review</button>
                <button class="status-btn" data-status="Resolved" data-id="${report.case_id}">Mark Resolved</button>
            </div>
        `;
        
        // Add event listeners to status buttons
        document.querySelectorAll('.status-btn').forEach(btn => {
            btn.addEventListener('click', updateStatus);
        });
        
        modal.style.display = 'block';
    } catch (error) {
        console.error('Error loading report details:', error);
        alert('Failed to load report details');
    }
}

async function updateStatus(e) {
    const caseId = e.target.getAttribute('data-id');
    const newStatus = e.target.getAttribute('data-status');
    
    try {
        const response = await fetch('update_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ 
                case_id: caseId,
                status: newStatus 
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            loadReports(); // Refresh the list
            modal.style.display = 'none';
        } else {
            alert('Error updating status');
        }
    } catch (error) {
        console.error('Error updating status:', error);
    }
}