axios.get(`https://api.hypcvgm.top/spapi.php?timestamp=${new Date().getTime()}`)
    .then(function (response) {
        const sponsors = response.data.map(sponsor => ({
            name: sponsor.name,
            amount: sponsor.amount,
            message: sponsor.message
        }));
        const sponsorsDiv = document.getElementById('sponsors');
        sponsors.forEach(sponsor => {
            const sponsorDiv = document.createElement('div');
            sponsorDiv.className = "member p-4 max-w-md mx-auto bg-white rounded-xl shadow-md space-y-2 mb-4";
            sponsorDiv.innerHTML = `
                <p class="member-name"><strong>赞助者名称：</strong>${sponsor.name}</p>
                <p class="member-amount"><strong>赞助金额：</strong>${sponsor.amount}</p>
                <p class="member-message"><strong>赞助于：</strong>${sponsor.message}</p>
            `;
            sponsorsDiv.appendChild(sponsorDiv);
        });
    })
    .catch(function (error) {
        console.error('Error fetching sponsors:', error);
    });
