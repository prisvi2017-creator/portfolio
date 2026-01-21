// Configuration de Jitsi Meet
const domain = 'meet.jit.si';
const options = {
    roomName: 'MyJitsiRoom', // Remplacez par le nom de votre salle
    width: 800,
    height: 600,
    parentNode: document.querySelector('#jitsi-container'),
    configOverwrite: {},
    interfaceConfigOverwrite: {},
};

// Créez l'instance Jitsi Meet
const api = new JitsiMeetExternalAPI(domain, options);

// Ajoutez des gestionnaires d'événements pour les boutons
document.getElementById('toggleAudio').addEventListener('click', () => {
    api.executeCommand('toggleAudio');
});

document.getElementById('toggleVideo').addEventListener('click', () => {
    api.executeCommand('toggleVideo');
});

// Ajouter des gestionnaires d'événements pour les états audio et vidéo
api.addEventListener('audioMuteStatusChanged', (event) => {
    document.getElementById('toggleAudio').textContent = event.muted ? 'Unmute Audio' : 'Mute Audio';
});

api.addEventListener('videoMuteStatusChanged', (event) => {
    document.getElementById('toggleVideo').textContent = event.muted ? 'Turn On Video' : 'Turn Off Video';
});
