<!-- Head -->
<?= loadPartial("head") ?>

<!-- Nav -->
<?= loadPartial("navbar") ?>

<!-- Top Banner -->
<?= loadPartial("top-banner") ?>

<section class="flex justify-center items-center mt-20">
  <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-600 mx-6">
    <h2 class="text-4xl text-center font-bold mb-4">Edit Job Listing</h2>
    <form method="POST" action="/listings/<?= $listing->id ?>">
      <input type="hidden" name="_method" value="PUT">
      <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
        Job Info
      </h2>
      <?php if (isset($errors)) : ?>
        <div class="message bg-red-100 my-3 p-3 rounded">
          <ul>
            <?php foreach ($errors as $error) : ?>
              <li>&bull; <?= $error ?></li>
            <?php endforeach; ?>

          </ul>
        </div>
      <?php endif; ?>
      <div class="mb-4">
        <label class="text-gray-500" for="title">Title</label>
        <input type="text" name="title" value="<?= $listing->title ?? '' ?>" placeholder="Job Title" class="bg-gray-100 w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <label class="text-gray-500" for="description">Description</label>
        <textarea name="description" placeholder="Job Description" class="bg-gray-100 w-full px-4 py-2 border rounded focus:outline-none"><?= $listing->description ?? '' ?></textarea>
      </div>
      <div class="mb-4">
        <label class="text-gray-500" for="salary">Salary</label>
        <input type="text" name="salary" value="<?= $listing->salary ?? '' ?>" placeholder="Annual Salary" class="bg-gray-100 w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <label class="text-gray-500" for="requirements">Requirements</label>
        <input type="text" name="requirements" value="<?= $listing->requirements ?? '' ?>" placeholder="Requirements" class="bg-gray-100 w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <label class="text-gray-500" for="benefits">Benefits</label>
        <input type="text" name="benefits" value="<?= $listing->benefits ?? '' ?>" placeholder="Benefits" class="bg-gray-100 w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <label class="text-gray-500" for="tags">Tags</label>
        <input type="text" name="tags" value="<?= $listing->tags ?? '' ?>" placeholder="Tags" class="bg-gray-100 w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
        Company Info & Location
      </h2>
      <div class="mb-4">
        <label class="text-gray-500" for="company">Company Name</label>
        <input type="text" name="company" value="<?= $listing->company ?? '' ?>" placeholder="Company Name" class="bg-gray-100 w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <label class="text-gray-500" for="address">Street Address</label>
        <input type="text" name="address" value="<?= $listing->address ?? '' ?>" placeholder="Address" class="bg-gray-100 w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <label class="text-gray-500" for="city">City</label>
        <input type="text" name="city" value="<?= $listing->city ?? '' ?>" placeholder="City" class="bg-gray-100 w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <label class="text-gray-500" for="state">State</label>
        <input type="text" name="state" value="<?= $listing->state ?? '' ?>" placeholder="State" class="bg-gray-100 w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <label class="text-gray-500" for="country">Country</label>
        <input type="text" name="country" value="<?= $listing->country ?? '' ?>" placeholder="Country" class="bg-gray-100 w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <label class="text-gray-500" for="phone">Phone</label>
        <input type="text" name="phone" value="<?= $listing->phone ?? '' ?>" placeholder="Phone" class="bg-gray-100 w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <label class="text-gray-500" for="email">Email</label>
        <input type="email" name="email" value="<?= $listing->email ?? '' ?>" placeholder="Email Address For Applications" class="bg-gray-100 w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <button class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none">
        Save
      </button>
      <a href="/" class="block text-center w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded focus:outline-none">
        Cancel
      </a>
    </form>
  </div>
</section>

<!-- Bottom Banner -->
<?= loadPartial("bottom-banner") ?>


<?= loadPartial("footer") ?>