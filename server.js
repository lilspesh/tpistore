const express = require('express');
const sqlite3 = require('sqlite3').verbose();
const cors = require('cors');
const bodyParser = require('body-parser');

const app = express();
const PORT = 3000;

app.use(cors());
app.use(bodyParser.json());

// Init DB
const db = new sqlite3.Database(':memory:'); // En mémoire pour test
// Pour fichier disque, mettre ./rdv.db par ex.

db.serialize(() => {
  db.run(`CREATE TABLE IF NOT EXISTS rendezvous (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT,
    email TEXT,
    date TEXT,
    heure TEXT,
    statut TEXT
  )`);

  // Insert exemples
  const stmt = db.prepare("INSERT INTO rendezvous (nom, email, date, heure, statut) VALUES (?, ?, ?, ?, ?)");
  stmt.run("Jean Dupont", "jean.dupont@mail.com", "2025-07-12", "10:00", "En attente");
  stmt.run("Claire Moreau", "claire.moreau@mail.com", "2025-07-13", "14:30", "Validé");
  stmt.finalize();
});

// Routes

// GET tous les rendez-vous
app.get('/api/rendezvous', (req, res) => {
  db.all("SELECT * FROM rendezvous", (err, rows) => {
    if (err) return res.status(500).json({ error: err.message });
    res.json(rows);
  });
});

// DELETE un rendez-vous par id
app.delete('/api/rendezvous/:id', (req, res) => {
  const id = req.params.id;
  db.run("DELETE FROM rendezvous WHERE id = ?", id, function(err) {
    if (err) return res.status(500).json({ error: err.message });
    if (this.changes === 0) return res.status(404).json({ error: "Rendez-vous non trouvé" });
    res.json({ message: "Supprimé avec succès" });
  });
});

// PUT modifier un rendez-vous
app.put('/api/rendezvous/:id', (req, res) => {
  const id = req.params.id;
  const { nom, email, date, heure, statut } = req.body;
  db.run(
    "UPDATE rendezvous SET nom = ?, email = ?, date = ?, heure = ?, statut = ? WHERE id = ?",
    [nom, email, date, heure, statut, id],
    function(err) {
      if (err) return res.status(500).json({ error: err.message });
      if (this.changes === 0) return res.status(404).json({ error: "Rendez-vous non trouvé" });
      res.json({ message: "Modifié avec succès" });
    }
  );
});

// PUT valider un rendez-vous (change statut)
app.put('/api/rendezvous/:id/valider', (req, res) => {
  const id = req.params.id;
  db.run(
    "UPDATE rendezvous SET statut = 'Validé' WHERE id = ?",
    id,
    function(err) {
      if (err) return res.status(500).json({ error: err.message });
      if (this.changes === 0) return res.status(404).json({ error: "Rendez-vous non trouvé" });
      res.json({ message: "Rendez-vous validé" });
    }
  );
});

app.listen(PORT, () => {
  console.log(`Serveur lancé sur http://localhost:${PORT}`);
});
