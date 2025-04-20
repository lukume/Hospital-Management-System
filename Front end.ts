import React, { useState } from "react";
import { BrowserRouter as Router, Route, Routes, Link } from "react-router-dom";
import { Button, Card } from "@/components/ui/button";
import { motion } from "framer-motion";

const Home = () => (
  <div className="flex flex-col items-center justify-center h-screen">
    <h1 className="text-3xl font-bold mb-4">JKUSA 2025 Voting System</h1>
    <div className="flex gap-4">
      <Link to="/admin">
        <Button className="px-6 py-2 bg-blue-600 text-white rounded-xl">Admin</Button>
      </Link>
      <Link to="/voter">
        <Button className="px-6 py-2 bg-green-600 text-white rounded-xl">Voter</Button>
      </Link>
      <Link to="/candidate">
        <Button className="px-6 py-2 bg-purple-600 text-white rounded-xl">Candidate</Button>
      </Link>
    </div>
  </div>
);

const Admin = () => (
  <motion.div className="p-8" initial={{ opacity: 0 }} animate={{ opacity: 1 }}>
    <h2 className="text-2xl font-bold mb-4">Admin Dashboard</h2>
    <Card className="p-4">Manage elections, approve candidates, and monitor votes.</Card>
  </motion.div>
);

const Voter = () => (
  <motion.div className="p-8" initial={{ opacity: 0 }} animate={{ opacity: 1 }}>
    <h2 className="text-2xl font-bold mb-4">Voter Portal</h2>
    <Card className="p-4">Vote for your preferred candidates securely.</Card>
  </motion.div>
);

const Candidate = () => (
  <motion.div className="p-8" initial={{ opacity: 0 }} animate={{ opacity: 1 }}>
    <h2 className="text-2xl font-bold mb-4">Candidate Portal</h2>
    <Card className="p-4">Register, upload your manifesto, and track votes.</Card>
  </motion.div>
);

const App = () => (
  <Router>
    <Routes>
      <Route path="/" element={<Home />} />
      <Route path="/admin" element={<Admin />} />
      <Route path="/voter" element={<Voter />} />
      <Route path="/candidate" element={<Candidate />} />
    </Routes>
  </Router>
);

export default App;
