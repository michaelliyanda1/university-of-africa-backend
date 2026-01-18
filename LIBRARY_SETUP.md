# Library Resources Setup Instructions

## Database Setup

### 1. Run Migration
First, run the migration to create the library_resources table:

```bash
php artisan migrate
```

### 2. Run Seeder
To populate the database with the initial library resources (the hardcoded ones from the original page):

```bash
php artisan db:seed --class=LibraryResourceSeeder
```

### 3. Alternative: Run All Seeders
If you want to run all seeders including navigation and departments:

```bash
php artisan db:seed
```

## What Gets Seeded

The seeder will add the following library resources to your database:

1. **Project Gutenberg** - E-Books (Downloadable)
2. **MIT OpenCourseWare** - Courses (Online Access) 
3. **Google Scholar** - Research (Online Access)
4. **JSTOR** - Journals (Online Access)
5. **Open Library** - E-Books (Downloadable)
6. **PubMed** - Research (Online Access)
7. **Khan Academy** - Courses (Online Access)
8. **arXiv** - Research (Online Access)
9. **Internet Archive** - Multimedia (Downloadable)

## Management

Once seeded, you can manage these resources through:

### Admin Interface
- Go to: `/admin/dashboard`
- Click on "Library Resources"
- Add, edit, delete, or update resources as needed

### API Endpoints
- **Public**: `GET /api/library-resources` - Fetches all active resources
- **Admin**: `GET /api/admin/manage-library-resources` - Full management interface

## Features Available

- ✅ Add/Edit/Delete resources
- ✅ Toggle active/inactive status (working/not working)
- ✅ Featured resources highlighting
- ✅ Category management (E-Books, Courses, Research, Journals, Multimedia)
- ✅ Type classification (Downloadable vs Online Access)
- ✅ Image uploads
- ✅ Ratings and user counts
- ✅ Sort order management
- ✅ Search and filtering

## Public Display

The resources will be displayed on the public Library Services page at:
- `/library-services`

The page will automatically fetch from the database and display all active resources with the modern UI we created.
