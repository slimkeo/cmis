<?php
/* =========================
   MEMBER SELECTION PAGE
========================= */

// Get all members
$members = $this->db->get('members')->result_array();
?>

<style>
    .member-selection-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 30px;
        background: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .member-selection-header {
        text-align: center;
        margin-bottom: 30px;
    }
    
    .member-selection-header h2 {
        color: #333;
        margin-bottom: 10px;
    }
    
    .member-selection-header p {
        color: #666;
        font-size: 14px;
    }
    
    .form-group label {
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
        display: block;
    }
    
    #member_search {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        margin-bottom: 20px;
    }
    
    #member_search:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0,123,255,0.25);
    }
    
    .search-info {
        font-size: 12px;
        color: #999;
        margin-bottom: 20px;
    }
    
    .btn-select-member {
        width: 100%;
        padding: 12px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s;
    }
    
    .btn-select-member:hover {
        background: #0056b3;
    }
    
    .btn-select-member:disabled {
        background: #ccc;
        cursor: not-allowed;
    }
    
    .loading-spinner {
        display: none;
        text-align: center;
        padding: 20px;
    }
    
    .spinner {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #007bff;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .error-message {
        color: #d32f2f;
        padding: 10px;
        background: #ffebee;
        border-radius: 4px;
        margin-bottom: 20px;
        display: none;
    }
    
    .success-message {
        color: #388e3c;
        padding: 10px;
        background: #e8f5e9;
        border-radius: 4px;
        margin-bottom: 20px;
        display: none;
    }
</style>

<div class="member-selection-container">
    <div class="member-selection-header">
        <h2>Select Member</h2>
        <p>Choose a member to view their details and beneficiaries</p>
    </div>
    
    <div class="error-message" id="error_message"></div>
    <div class="success-message" id="success_message"></div>
    
    <div class="form-group">
        <label for="member_search">Member Name or ID Number:</label>
        <input 
            type="text" 
            id="member_search" 
            placeholder="Search by name, ID number, or passbook..." 
            autocomplete="off"
        >
        <div class="search-info">
            Type to search members by their name, ID number, or passbook number
        </div>
    </div>
    
    <div id="member_dropdown" style="margin-bottom: 20px; display: none;">
        <label for="member_select">Select Member:</label>
        <select id="member_select" class="form-control">
            <option value="">-- Select a member --</option>
        </select>
    </div>
    
    <div class="loading-spinner" id="loading_spinner">
        <div class="spinner"></div>
        <p>Loading member details...</p>
    </div>
    
    <button 
        class="btn-select-member" 
        id="btn_select" 
        onclick="loadMemberDetails()" 
        disabled
    >
        View Details
    </button>
</div>

<script>
// Store filtered members
let filteredMembers = [];

// Member search input handler
document.getElementById('member_search').addEventListener('keyup', function(e) {
    const searchValue = this.value.trim().toLowerCase();
    
    if (searchValue.length < 1) {
        document.getElementById('member_dropdown').style.display = 'none';
        document.getElementById('member_select').value = '';
        document.getElementById('btn_select').disabled = true;
        document.getElementById('error_message').style.display = 'none';
        return;
    }
    
    // Get all members from the backend
    const allMembers = <?php echo json_encode($members); ?>;
    
    // Filter members based on search
    filteredMembers = allMembers.filter(member => {
        const fullName = (member.surname + ' ' + member.name).toLowerCase();
        const idNumber = (member.idnumber || '').toLowerCase();
        const passbookNo = (member.passbook_no || '').toLowerCase();
        
        return fullName.includes(searchValue) || 
               idNumber.includes(searchValue) || 
               passbookNo.includes(searchValue);
    });
    
    if (filteredMembers.length > 0) {
        populateMemberSelect(filteredMembers);
        document.getElementById('member_dropdown').style.display = 'block';
        document.getElementById('error_message').style.display = 'none';
    } else if (searchValue.length >= 2) {
        document.getElementById('member_dropdown').style.display = 'none';
        document.getElementById('error_message').textContent = 'No members found matching your search.';
        document.getElementById('error_message').style.display = 'block';
        document.getElementById('btn_select').disabled = true;
    }
});

// Member select change handler
document.getElementById('member_select').addEventListener('change', function() {
    document.getElementById('btn_select').disabled = this.value === '';
});

// Populate the member select dropdown
function populateMemberSelect(members) {
    const select = document.getElementById('member_select');
    select.innerHTML = '<option value="">-- Select a member --</option>';
    
    members.forEach(member => {
        const option = document.createElement('option');
        option.value = member.id;
        option.textContent = member.surname + ' ' + member.name + ' (' + member.idnumber + ')';
        select.appendChild(option);
    });
    
    select.value = '';
}

// Load member details
function loadMemberDetails() {
    const memberId = document.getElementById('member_select').value;
    
    if (!memberId) {
        document.getElementById('error_message').textContent = 'Please select a member first.';
        document.getElementById('error_message').style.display = 'block';
        return;
    }
    
    document.getElementById('loading_spinner').style.display = 'block';
    document.getElementById('error_message').style.display = 'none';
    
    // Redirect to member details page
    window.location.href = '<?php echo base_url(); ?>index.php?burial/member_details/' + memberId;
}

// Allow Enter key to select
document.getElementById('member_select').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        loadMemberDetails();
    }
});
</script>
