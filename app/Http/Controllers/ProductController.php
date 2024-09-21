<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Stock;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    /**
     * @var Product|null 产品模型
     */
    public ?Product $model = null;

    public function __construct()
    {
        $this->model = new Product();
    }

    public function showCreateForm(Request $request): Factory|View|Application
    {
        return view('product.create');
    }

    /**
     * 显示所有产品
     *
     * @return Factory|View|Application
     */
    public function index(Request $request): \Illuminate\View\View
    {
        // 获取商品分类和品牌
        $categories = Category::all();
        $brands = Brand::all();


        $products = Product::all();

        // 使用分页，每页显示10个商品
        $products = Product::paginate(10);

        return view('product.index', compact('products', 'categories', 'brands'));
    }



    public function create()
    {
        $categories = Category::all(); // 获取所有分类
        $brands = Brand::all(); // 获取所有品牌

        return view('product.create', compact('categories', 'brands')); // 传递到视图
    }

    public function store(Request $request)
    {
        // 验证数据并创建商品
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048' // 验证图片格式和大小
        ]);

        // 创建商品
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'brand_id' => $validated['brand_id'],
        ]);
        // 创建库存记录
        Stock::create([
            'product_id' => $product->id,
            'quantity' => $validated['stock'], // 从请求中获取库存数据
            'warehouse_location' => '默认仓库', // 可以根据你的业务逻辑进行设置
        ]);


        // 处理图片上传
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public'); // 存储图片到 storage/app/public/images 目录
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $path,
                ]);
            }
        }

        // 成功后重定向到产品列表页面
        return redirect()->route('product.index')->with('success', '商品创建成功');
    }


    /**
     * 显示产品详情
     *
     * @param $id
     * @return Factory|View|Application
     */

    public function show($id): Factory|View|Application
    {
        $product = Product::find($id);
        return view('product.show', ['product' => $product]);
    }

    /**
     * 删除商品
     *
     * @param $id
     * @return RedirectResponse
     */

    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return redirect()->route('product.index')->with('success', '商品已删除');
        }

        return redirect()->route('product.index')->with('error', '商品未找到');
    }


    /**
     * 编辑商品
     *
     * @param $id
     * @return Factory|View|Application
     */
    public function edit($id): Factory|View|Application
    {
        $product =Product::find($id);
        return view('product.edit', ['product' => $product]);
    }

    /**
     * 更新商品
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // 找到商品模型
        $product = Product::find($id);

        // 确保商品存在
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        // 找到库存模型实例
        $stock = $product->stock; // 确保这是一个模型实例

        // 如果库存模型实例存在，更新库存
        if ($stock) {
            $stock->update(['quantity' => $request->stock]);
        } else {
            // 如果库存模型实例不存在，你可以选择创建新的库存记录
            Stock::create([
                'product_id' => $product->id,
                'quantity' => $request->stock,
            ]);
        }

        // 更新商品本身的其他属性
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            // 这里的 'stock' 是商品的库存字段，确保在模型中定义了这个字段
        ]);


    // 处理图片上传
        if ($request->hasFile('images')) {
            $images = $request->file('images');


            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public'); // 存储图片到 storage/app/public/images 目录

                // 删除旧图片
                if ($product->images()->exists()) {
                    foreach ($product->images as $oldImage) {
                        Storage::disk('public')->delete($oldImage->image_url); // 删除旧图片文件
                        $oldImage->delete(); // 删除旧图片记录
                    }
                }

                // 保存新图片到数据库
                $product->images()->create([
                    'image_url' => $path,
                ]);
            }
        }


        // 保存商品信息
        $product->save();

        return redirect()->route('product.index')->with('success', '商品更新成功！');
    }


    /**
     * 搜索商品
     *
     * @param Request $request
     * @return Application|Factory|View|void
     */
    public function search(Request $request)
    {
        // 获取搜索输入内容
        $query = $request->input('search');

        if ($query) {
            // 执行搜索，按商品编号、名称、品牌搜索
            $products = Product::where('id', 'like', "%{$query}%") // 商品编号
            ->Where('name', 'like', "%{$query}%") // 商品名称
            ->WhereHas('brand', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%"); // 商品品牌名称
            })
                ->get();

            return view('product.search', compact('products', 'query'));
        }

        return view('product.search')->withErrors('请输入搜索条件');
    }
    /**
     * 筛选商品
     *
     * @param Request $request
     * @return Application|Factory|View
     */

    public function filter(Request $request)
    {
        $query = Product::query();

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }


        // 分页查询
        $products = $query->paginate(10);

        $categories = Category::all();
        $brands = Brand::all();

        return view('product.index', compact('products', 'categories', 'brands'));
    }



}
