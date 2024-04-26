function adjustData(member) {
    if (member.rank === "Guild Master") {
        member.rank = "伟大的JuziClub会长";
    }
    if (member.name === "Juzi_CN") {
        member.name += "[✈余信逸]";
        member.joined = "会长哪来的加入时间😅";
    } else if (member.name === "BHCN") {
        member.name += "[❤王腾杰❤]";
        member.rank = "公会人才";
        member.joined = "1145年14月";
    } else if (member.name === "F740") { 
        member.name += "[国民老公]";
    } else if (member.name === "Its_love") { 
        member.name += "[可乐v我50]";
    } else if (member.name === "7ulyer") { 
        member.name += "[柒月]";
        member.joined = "公会创立那天吧[表情]";
    } else if (member.name === "An5ue") { 
        member.name += "[南梁]";
        member.rank = "公会南梁";
    } else if (member.name === "lateritious") { 
        member.name += "[JCLY最吊数据号]";
    } else if (member.name === "lroe") { 
        member.name += "[死了，正在打复活赛]";
    } else if (member.name === "Cyemology") { 
        member.name += "[新西兰爷]";
    } else if (member.name === "SnowToYou") { 
        member.name += "[富哥]";
    } else if (member.name === "skybooko") { 
        member.name += "[公会最强Skyblock玩家]";
    }
    member.joined += "";
    return member;
}

axios.get(`https://juzi.club/guilds/juziclub_guild.php?timestamp=${new Date().getTime()}`)
    .then(function (response) {
        const members = response.data.map(adjustData);
        const membersDiv = document.getElementById('members');
        members.forEach(member => {
            const memberDiv = document.createElement('div');
            memberDiv.className = "member p-4 max-w-md mx-auto bg-white rounded-xl shadow-md space-y-2 mb-4";
            memberDiv.innerHTML = `
                <p class="member-name"><strong>成员名称：</strong>${member.name}</p>
                <p class="member-rank"><strong>公会职务：</strong>${member.rank}</p>
                <p class="member-joined"><strong>加入时间：</strong>${member.joined}</p>
            `;
            membersDiv.appendChild(memberDiv);
        });
    })
    .catch(function (error) {
        console.error('Error fetching members:', error);
    });