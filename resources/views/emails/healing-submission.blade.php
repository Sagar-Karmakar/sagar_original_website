<!DOCTYPE html>
<html>
<head>
    <title>Healing Request</title>
</head>
<body style="font-family: sans-serif; line-height: 1.6; color: #333;">
    <h2>New Healing Support Request</h2>
    
    <h3>Basic Details</h3>
    <ul>
        <li><strong>Name:</strong> {{ $data['name'] ?? 'N/A' }}</li>
        <li><strong>Email:</strong> {{ $data['email'] ?? 'N/A' }}</li>
        <li><strong>Phone:</strong> {{ $data['phone'] ?? 'N/A' }}</li>
        <li><strong>Age:</strong> {{ $data['age'] ?? 'N/A' }}</li>
        <li><strong>Preferred Contact:</strong> {{ $data['contact_pref'] ?? 'N/A' }}</li>
    </ul>

    <h3>Safety & Clarity</h3>
    <ul>
        <li><strong>Under Treatment:</strong> {{ $data['treatment'] ?? 'N/A' }}</li>
        <li><strong>Replacing Care:</strong> {{ $data['replace_care'] ?? 'N/A' }}</li>
    </ul>

    <h3>The Issue</h3>
    <p><strong>Reason for reaching out:</strong></p>
    <blockquote style="background: #f9f9f9; padding: 10px; border-left: 4px solid #ccc;">
        {{ $data['reason'] ?? 'N/A' }}
    </blockquote>
    
    <ul>
        <li><strong>Intensity:</strong> {{ $data['intensity'] ?? 'N/A' }}/10</li>
        <li><strong>Current State:</strong> {{ $data['state'] ?? 'N/A' }}</li>
        <li><strong>Primary Sense:</strong> {{ $data['sense'] ?? 'N/A' }}</li>
        <li><strong>Body Location:</strong> {{ $data['location'] ?? 'N/A' }}</li>
        <li><strong>Time Orientation:</strong> {{ $data['time'] ?? 'N/A' }}</li>
    </ul>

    <h3>Impact</h3>
    <ul>
        <li><strong>Impact Level:</strong> {{ $data['impact_level'] ?? 'N/A' }}</li>
        <li><strong>Areas Affected:</strong> 
            @if(isset($data['impact_area']) && is_array($data['impact_area']))
                {{ implode(', ', $data['impact_area']) }}
            @else
                {{ $data['impact_area'] ?? 'N/A' }}
            @endif
        </li>
        <li><strong>History:</strong> {{ $data['history'] ?? 'N/A' }}</li>
    </ul>

    <h3>Support</h3>
    <p><strong>Resources:</strong> {{ $data['resources'] ?? 'N/A' }}</p>
    <p><strong>Session Goal:</strong> {{ $data['goal'] ?? 'N/A' }}</p>
    <p><strong>Openness to exercises:</strong> {{ $data['openness'] ?? 'N/A' }}</p>

</body>
</html>
