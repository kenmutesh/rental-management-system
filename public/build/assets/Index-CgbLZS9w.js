import{p as c,o as r,f as n,a as i,w as b,F as u,b as t,t as l,s as h,g as m}from"./app-BtpFdyZw.js";import{_ as x}from"./_plugin-vue_export-helper-DlAUqK2U.js";const _={data(){return{backups:[],totalBackups:0}},methods:{loadBackups(){this.backups=[{id:1,name:"Backup 1",date:"2024-10-20"},{id:2,name:"Backup 2",date:"2024-10-18"},{id:3,name:"Backup 3",date:"2024-10-15"}],this.totalBackups=this.backups.length},createBackup(){console.log("Creating a new backup...");const a={id:this.backups.length+1,name:`Backup ${this.backups.length+1}`,date:new Date().toLocaleDateString()};this.backups.push(a),this.totalBackups=this.backups.length},restoreBackup(a){console.log(`Restoring backup with ID: ${a}`)},deleteBackup(a){console.log(`Deleting backup with ID: ${a}`),this.backups=this.backups.filter(e=>e.id!==a),this.totalBackups=this.backups.length}},mounted(){this.loadBackups()}},B={class:"container mx-auto px-4 py-6"},y={class:"mb-6 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6"},v={class:"mt-2 text-lg font-medium text-blue-600"},f={class:"mb-6 text-right"},w={class:"mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"},C={class:"text-lg font-semibold text-gray-900 dark:text-gray-100"},D={class:"mt-2 text-sm text-gray-500 dark:text-gray-300"},N={class:"mt-4"},V=["onClick"],I=["onClick"],F={key:0,class:"text-center text-gray-500 dark:text-gray-300"};function H(a,e,L,R,d,o){const p=c("Head"),g=c("app-layout");return r(),n(u,null,[i(p,{title:"Backups"}),i(g,null,{default:b(()=>[t("div",B,[e[3]||(e[3]=t("div",{class:"mb-6 text-center"},[t("h1",{class:"text-3xl font-semibold text-gray-900 dark:text-gray-100"},"Manage Backups"),t("p",{class:"text-gray-500 dark:text-gray-300"},"View and manage your system backups.")],-1)),t("div",y,[e[1]||(e[1]=t("h3",{class:"text-xl font-semibold text-gray-900 dark:text-gray-100"},"Total Backups",-1)),t("p",v,l(d.totalBackups),1)]),t("div",f,[t("button",{onClick:e[0]||(e[0]=(...s)=>o.createBackup&&o.createBackup(...s)),class:"text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-md transition duration-300 ease-in-out dark:bg-blue-700 dark:hover:bg-blue-800"}," Create Backup ")]),t("div",w,[(r(!0),n(u,null,h(d.backups,s=>(r(),n("div",{key:s.id,class:"bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6"},[t("h4",C,l(s.name),1),t("p",D,l(s.date),1),t("div",N,[t("button",{onClick:k=>o.restoreBackup(s.id),class:"text-white bg-green-500 hover:bg-green-600 px-4 py-2 rounded-md transition duration-300 ease-in-out dark:bg-green-700 dark:hover:bg-green-800"}," Restore ",8,V),t("button",{onClick:k=>o.deleteBackup(s.id),class:"ml-2 text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded-md transition duration-300 ease-in-out dark:bg-red-700 dark:hover:bg-red-800"}," Delete ",8,I)])]))),128))]),d.backups.length===0?(r(),n("div",F,e[2]||(e[2]=[t("p",null,"No backups available.",-1)]))):m("",!0)])]),_:1})],64)}const E=x(_,[["render",H],["__scopeId","data-v-bf9129ec"]]);export{E as default};
