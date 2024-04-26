document.addEventListener('DOMContentLoaded', function() {
    const sponsors = [
        {
            siname: '冰火使者',
            siign: 'IAFEnvoy',
            sireason: '后踹开发'
        },
        {
            siname: '𝓟𝓵𝓪𝔂𝓮𝓻_𝔁𝔃',
            siign: 'Player_xz',
            sireason: 'XzGame 会长'
        },
        {
            siname: '广告位招租',
            siign: 'AD space rental',
            sireason: '我要圈钱'
        },
    ];

    const sponsorsDiv = document.getElementById('sponsor-members');
    sponsors.forEach(sponsor => {
        const sponsorDiv = document.createElement('div');
        sponsorDiv.className = "member p-4 max-w-md mx-auto bg-white rounded-xl shadow-md space-y-2 mb-4";
        sponsorDiv.innerHTML = `
            <p class="member-siname"><strong>特邀人员：</strong>${sponsor.siname}</p>
            <p class="member-siign"><strong>游戏名称：</strong>${sponsor.siign}</p>
            <p class="member-sireason"><strong>特邀原因：</strong>${sponsor.sireason}</p>
        `;
        sponsorsDiv.appendChild(sponsorDiv);
    });
});
