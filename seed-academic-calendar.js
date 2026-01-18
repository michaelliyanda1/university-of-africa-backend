const mongoose = require('mongoose');
require('dotenv').config();

// MongoDB connection
const connectDB = async () => {
  try {
    const conn = await mongoose.connect(process.env.MONGODB_URI || 'mongodb://localhost:27017/academic_calendar');
    console.log('✅ Connected to MongoDB');
    return conn;
  } catch (error) {
    console.error('❌ MongoDB connection error:', error);
    process.exit(1);
  }
};

// Academic Event Schema
const EventSchema = new mongoose.Schema({
  event: {
    type: String,
    required: true,
    trim: true
  },
  date: {
    type: String,
    required: true,
    trim: true
  },
  type: {
    type: String,
    required: true,
    enum: ['Academic', 'Exams', 'Break', 'Holiday', 'Event'],
    default: 'Academic'
  },
  description: {
    type: String,
    required: true,
    trim: true
  },
  location: {
    type: String,
    required: true,
    trim: true
  },
  importance: {
    type: String,
    required: true,
    enum: ['high', 'medium', 'low'],
    default: 'medium'
  },
  attendees: {
    type: Number,
    required: true,
    default: 0
  },
  status: {
    type: String,
    required: true,
    enum: ['upcoming', 'completed', 'cancelled'],
    default: 'upcoming'
  },
  createdAt: {
    type: Date,
    default: Date.now
  },
  updatedAt: {
    type: Date,
    default: Date.now
  }
}, {
  timestamps: true
});

const Event = mongoose.model('Event', EventSchema);

// Dummy academic calendar data
const dummyEvents = [
  {
    event: 'First Semester Begins',
    date: '2026-01-15',
    type: 'Academic',
    description: 'Start of first semester for all undergraduate and graduate programs',
    location: 'Main Campus',
    importance: 'high',
    attendees: 2500,
    status: 'upcoming'
  },
  {
    event: 'Orientation Week',
    date: '2026-01-20',
    type: 'Event',
    description: 'Welcome and orientation activities for new students',
    location: 'Main Campus',
    importance: 'medium',
    attendees: 500,
    status: 'upcoming'
  },
  {
    event: 'Mid-Semester Break',
    date: '2026-02-10',
    type: 'Break',
    description: 'One week break for students and faculty',
    location: 'All Campuses',
    importance: 'medium',
    attendees: 2500,
    status: 'upcoming'
  },
  {
    event: 'First Semester Examinations',
    date: '2026-03-20',
    type: 'Exams',
    description: 'Final examinations for first semester',
    location: 'Various Locations',
    importance: 'high',
    attendees: 2500,
    status: 'upcoming'
  },
  {
    event: 'Second Semester Begins',
    date: '2026-04-01',
    type: 'Academic',
    description: 'Start of second semester for all programs',
    location: 'Main Campus',
    importance: 'high',
    attendees: 2500,
    status: 'upcoming'
  },
  {
    event: 'Easter Holiday',
    date: '2026-04-05',
    type: 'Holiday',
    description: 'Easter holiday break for students and faculty',
    location: 'All Campuses',
    importance: 'low',
    attendees: 2500,
    status: 'upcoming'
  },
  {
    event: 'Mid-Semester Break',
    date: '2026-05-15',
    type: 'Break',
    description: 'One week break for students and faculty',
    location: 'All Campuses',
    importance: 'medium',
    attendees: 2500,
    status: 'upcoming'
  },
  {
    event: 'Second Semester Examinations',
    date: '2026-06-15',
    type: 'Exams',
    description: 'Final examinations for second semester',
    location: 'Various Locations',
    importance: 'high',
    attendees: 2500,
    status: 'upcoming'
  },
  {
    event: 'Graduation Ceremony',
    date: '2026-07-10',
    type: 'Academic',
    description: 'Annual graduation ceremony for graduating students',
    location: 'Main Auditorium',
    importance: 'high',
    attendees: 1500,
    status: 'upcoming'
  },
  {
    event: 'Summer Session',
    date: '2026-08-01',
    type: 'Academic',
    description: 'Optional summer session for interested students',
    location: 'Main Campus',
    importance: 'low',
    attendees: 500,
    status: 'upcoming'
  },
  {
    event: 'Faculty Development Workshop',
    date: '2026-09-05',
    type: 'Event',
    description: 'Professional development workshop for faculty members',
    location: 'Conference Center',
    importance: 'medium',
    attendees: 150,
    status: 'upcoming'
  },
  {
    event: 'Research Symposium',
    date: '2026-10-15',
    type: 'Event',
    description: 'Annual research symposium showcasing student and faculty research',
    location: 'Science Building',
    importance: 'medium',
    attendees: 300,
    status: 'upcoming'
  },
  {
    event: 'Fall Semester Begins',
    date: '2026-09-01',
    type: 'Academic',
    description: 'Start of fall semester for all programs',
    location: 'Main Campus',
    importance: 'high',
    attendees: 2500,
    status: 'upcoming'
  },
  {
    event: 'Thanksgiving Holiday',
    date: '2026-11-25',
    type: 'Holiday',
    description: 'Thanksgiving holiday break',
    location: 'All Campuses',
    importance: 'low',
    attendees: 2500,
    status: 'upcoming'
  },
  {
    event: 'Final Examinations',
    date: '2026-12-15',
    type: 'Exams',
    description: 'Final examinations for fall semester',
    location: 'Various Locations',
    importance: 'high',
    attendees: 2500,
    status: 'upcoming'
  },
  {
    event: 'Winter Break',
    date: '2026-12-20',
    type: 'Break',
    description: 'Winter break for students and faculty',
    location: 'All Campuses',
    importance: 'medium',
    attendees: 2500,
    status: 'upcoming'
  },
  {
    event: 'Spring Semester Begins',
    date: '2027-01-15',
    type: 'Academic',
    description: 'Start of spring semester for all programs',
    location: 'Main Campus',
    importance: 'high',
    attendees: 2500,
    status: 'upcoming'
  }
];

// Seed database with dummy data
const seedDatabase = async () => {
  try {
    console.log('🌱 Seeding academic calendar database...');
    
    // Clear existing events
    await Event.deleteMany({});
    console.log('🗑️ Cleared existing events');
    
    // Insert dummy events
    const insertedEvents = await Event.insertMany(dummyEvents);
    console.log(`✅ Successfully inserted ${insertedEvents.length} academic events`);
    
    // Display summary
    console.log('\n📅 Academic Calendar Events Added:');
    dummyEvents.forEach((event, index) => {
      console.log(`${index + 1}. ${event.event} - ${event.date} (${event.type})`);
      console.log(`   Location: ${event.location}`);
      console.log(`   Description: ${event.description}`);
      console.log(`   Importance: ${event.importance}`);
      console.log(`   Attendees: ${event.attendees}`);
      console.log(`   Status: ${event.status}`);
      console.log('---');
    });
    
    console.log('\n🎉 Database seeding completed successfully!');
    console.log('\n💡 Your Academic Calendar is now populated with sample data.');
    console.log('\n🌐 You can now access the calendar at:');
    console.log('   - Public: http://localhost:3000/academic-calendar');
    console.log('   - Admin: http://localhost:3000/admin/calendar');
    
  } catch (error) {
    console.error('❌ Error seeding database:', error);
  } finally {
    await mongoose.disconnect();
    console.log('🔌 Disconnected from MongoDB');
  }
};

// Main execution
const main = async () => {
  await connectDB();
  await seedDatabase();
  process.exit(0);
};

// Run if this script is executed directly
if (require.main === module) {
  main();
}

module.exports = { seedDatabase, connectDB };
