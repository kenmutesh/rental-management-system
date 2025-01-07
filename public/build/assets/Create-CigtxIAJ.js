import{l as r,h as M,m as _,p as T,o as n,c as B,w as C,b as l,i as g,q as p,f as d,F as b,s as v,g as f,x as h,t as c}from"./app-2cVQaEGG.js";/* empty css            */const P={class:"container mx-auto px-4 py-6"},E={class:"flex flex-col lg:flex-row gap-6"},U={class:"flex-1 bg-white shadow rounded-lg p-6 mb-6 lg:mb-0"},V={key:0,class:"mb-4"},F=["onClick"],N={key:1},R={class:"mb-4"},W={class:"flex-1 bg-white shadow rounded-lg p-6"},A={__name:"Create",setup(D){const o=r(""),a=r([]),u=r("");r(null),r("");const i=r([]);r([{id:1,content:"Hello, your rent is due."},{id:2,content:"Reminder: Meeting tomorrow at 10 AM."}]);let x=M(()=>{var s;let e=new URL(route("communication.create"));return u.value&&e.searchParams.append("search",((s=u.value)==null?void 0:s.toString())||""),e.toString()});_(()=>x.value,e=>{u.value&&h.visit(e,{preserveScroll:!0,preserveState:!0,replace:!0,method:"get",onSuccess:s=>{i.value=s.props.tenants}})});function y(e){const s=a.value.findIndex(m=>m.id===e.id);s===-1?(a.value.push(e),u.value="",i.value=[e]):(a.value.splice(s,1),a.value.length===0&&(i.value=[]))}function k(e){if(e.startsWith("0")?e="254"+e.slice(1):(e.startsWith("7")||e.startsWith("1"))&&(e="254"+e),e.length!==12)throw new Error("Phone number must be 12 characters long after formatting.");return e}function w(){if(a.value.length<1)alert("Please select at least one tenant");else if(!o.value)alert("Please enter a message to proceed");else try{const e=a.value.map(s=>{const m=k(s.phone);return{user_id:s.id,phone:m}});h.post(route("communication.single"),{tenants:e,message:o.value},{onSuccess:()=>{a.value=[],o.value="",alert("Message sent successfully!")},onError:s=>{console.error("Error sending message:",s)}})}catch(e){alert(e.message)}}function S(){o.value&&a.value.length>0?axios.post("/api/messages/bulk",{message:o.value,tenants:a.value.map(e=>e.id)}).then(e=>{console.log("Bulk message sent:",e.data)}).catch(e=>{console.error("Error sending bulk message:",e)}):alert("Please select tenants and provide a message.")}return(e,s)=>{const m=T("app-layout");return n(),B(m,null,{default:C(()=>[l("div",P,[s[7]||(s[7]=l("h1",{class:"text-2xl font-semibold mb-6"},"Send Messages",-1)),l("div",E,[l("div",U,[s[5]||(s[5]=l("h2",{class:"text-lg font-semibold mb-4"},"Send Single Message",-1)),g(l("input",{type:"text","onUpdate:modelValue":s[0]||(s[0]=t=>u.value=t),placeholder:"Search by tenant name or phone number",class:"block w-full border border-gray-300 rounded-md mb-4",onInput:s[1]||(s[1]=(...t)=>e.searchTenants&&e.searchTenants(...t))},null,544),[[p,u.value]]),i.value.length>0?(n(),d("ul",V,[(n(!0),d(b,null,v(i.value,t=>(n(),d("li",{key:t.id,onClick:I=>y(t),class:"cursor-pointer p-2 bg-gray-100 mb-2 rounded-md hover:bg-gray-200"},c(t.name)+" ("+c(t.phone)+") ",9,F))),128))])):f("",!0),a.value.length>0?(n(),d("div",N,[s[4]||(s[4]=l("p",{class:"font-semibold mb-2"},"Selected Tenants:",-1)),l("ul",R,[(n(!0),d(b,null,v(a.value,t=>(n(),d("li",{key:t.id,class:"p-2 bg-blue-100 mb-2 rounded-md"},c(t.name)+" ("+c(t.phone)+") ",1))),128))])])):f("",!0),g(l("textarea",{"onUpdate:modelValue":s[2]||(s[2]=t=>o.value=t),placeholder:"Type your message",class:"block w-full border border-gray-300 rounded-md mb-4"},null,512),[[p,o.value]]),l("button",{onClick:w,class:"bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"}," Send Message ")]),l("div",W,[s[6]||(s[6]=l("h2",{class:"text-lg font-semibold mb-4"},"Send Bulk Message",-1)),g(l("textarea",{"onUpdate:modelValue":s[3]||(s[3]=t=>o.value=t),placeholder:"Type your message",class:"block w-full border border-gray-300 rounded-md mb-4"},null,512),[[p,o.value]]),l("button",{onClick:S,class:"bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"}," Send Bulk Message ")])])])]),_:1})}}};export{A as default};
